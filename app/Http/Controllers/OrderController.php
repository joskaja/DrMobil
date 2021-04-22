<?php


namespace App\Http\Controllers;


use App\Events\OrderStatusChanged;
use App\Models\Address;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * List all logged in user's orders
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = Auth::user();
        return view('eshop.orders',
            ['orders' => $user->orders()->orderBy('created_at', 'desc')->get()]
        );
    }

    /**
     * Show current user's order detail
     * @param int $order
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function show(int $order) {
        $order = Order::find($order);
        if(!empty($order) && $order->user()->is(Auth::user())) {
            return view('eshop.order',
                ['order' => $order]);
        } else {
            return redirect(route('user.orders'));
        }
    }

    /**
     * Create new order
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $request->validate([
            'product' => 'required|array|min:1',
            'delivery_method' => 'required|integer',
            'payment_method' => 'required|integer',
            'email' => 'required|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|regex:^\d{5}(?:[-\s]\d{4})?$^|max:255',
        ], [], [
            'payment_method' => 'způsob platby',
            'delivery_method' => 'způsob dodání',
            'product' => 'produkt',
            'first_name' => 'jméno',
            'last_name' => 'přijmení',
            'street' => 'ulice',
            'house_number' => 'číslo popisné',
            'city' => 'město',
            'zip_code' => 'PSČ']);
        $delivery_method = DeliveryMethod::findOrFail($request->delivery_method);
        $payment_method = PaymentMethod::findOrFail($request->payment_method);
        $address = Address::create([
            'street' => $request->street,
            'house_number' => $request->house_number,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
        ]);
        if (Auth::user()) {
            $user = Auth::user();
        } else {
            if (!$user = User::where('email', $request->email)->first()) {
                $user = User::create([
                    'email' => $request->email,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'active' => false
                ]);
            }
        }
        if (empty($user->address_id)) {
            $user->address()->associate($address);
            $user->save();
        }
        $order = new Order();
        $order->status = 1;
        $order->user()->associate($user);
        $order->address()->associate($address);
        $order->delivery_method()->associate($delivery_method);
        $order->payment_method()->associate($payment_method);
        $order->saveQuietly();
        foreach ($request->product as $product => $amount) {
            $product = Product::find($product);
            if ($product && $amount > 0) {
                OrderProduct::create([
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'amount' => $amount,
                    'price' => $product->price
                ]);
            }
        }
        event(new OrderStatusChanged($order->refresh()));
        $basket = (new BasketController)->get(false);
        $basket->delete();
        $request->session()->forget('basket_form');
        $request->session()->put('last_order_id', $order->id);
        return redirect(route('order.finished', $order->id));
    }

    /**
     * Show messeage after successful order
     * @param int $order
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function ordered(int $order)
    {
        $order = Order::find($order);
        if (!empty($order) && $order->id === (int)session()->get('last_order_id')) {
            return view('eshop.ordered', [
                'order' => $order
            ]);
        } else {
            return redirect(route('home'));
        }
    }

    /**
     * List all orders in admin view
     * @return Application|Factory|View
     */
    public function adminIndex() {
        return view('admin.orders',
            ['orders' => Order::orderBy('created_at', 'desc')->orderBy('status', 'asc')->paginate(20, ['*'], 'strana'),
             'order_statuses' => (new Order())->statuses]
        );
    }

    /**
     * Show order detail in admin view
     * @param int $order
     * @return Application|Factory|View
     */
    public function adminShow(int $order) {
        return view('admin.order', [
           'order' =>  Order::findOrFail($order)
        ]);
    }

    /**
     * Update order status by ajax
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request) {
        $order = Order::find($request->order);
        if($order) {
            $order->status = $request->status;
            $order->save();
            return response()->json(['status' => 'ok', 'new_status' => $order->status]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}
