<?php


namespace App\Http\Controllers;


use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BasketController extends Controller
{

    /**
     * Show current user's basket in basket page view
     * @param Request $request
     * @return Application|Factory|View
     */
    public function show(Request $request)
    {
        $basket = $this->get(false);
        $user = new User();
        if(Auth::user()) {
            $user = Auth::user()->toArray();
            if (!empty(Auth::user()->address)) {
                $user += Auth::user()->address->toArray();
            }
        }
        $form_data = [];
        $session_basket = $request->session()->get('basket_form', []);
        foreach ($basket->form_data_keys as $form_data_key) {
            if(!empty($session_basket[$form_data_key]) || !empty($user[$form_data_key])) {
                $form_data[$form_data_key] = !empty($session_basket[$form_data_key]) ? $session_basket[$form_data_key] : $user[$form_data_key];
            } else {
                $form_data[$form_data_key] = '';
            }
        }
        $form_data['delivery_method'] = $session_basket['delivery_method'] ?? false;
        $form_data['payment_method'] = $session_basket['payment_method'] ?? false;

        return view('eshop.basket', [
            'basket' => $basket,
            'form_data' => $form_data,
            'delivery_methods' => DeliveryMethod::all(),
            'payment_methods' => PaymentMethod::all(),
        ]);
    }

    /**
     * Create new basket based on current user type (anonymous or logged in)
     * @return Basket
     */
    public function create(): Basket
    {
        $basket = new Basket();
        if (Auth::user()) {
            $user = User::find(Auth::id());
            $basket->user()->associate($user);
        } else {
            $basket->session_id = Session::getId();
        }
        $basket->save();
        return $basket;
    }

    /**
     * Get current instance of Basket with items
     * @param bool $create_if_not_exists if not exists create a new one
     * @return Basket
     */
    public function get(bool $create_if_not_exists = true): Basket
    {
        if (Auth::user()) {
            $basket = Basket::where('user_id', Auth::id())->first();
        } else {
            $basket = Basket::where('session_id', Session::getId())->first();
        }
        if (empty($basket)) {
            if ($create_if_not_exists) {
                $basket = $this->create();
            } else {
                $basket = new Basket();
            }
        }
        if (count($basket->items) > 0) {
            foreach ($basket->items as $basket_item) {
                if ($basket_item->amount > $basket_item->product->warehouse_amount && $basket_item->amount !== 1) {
                    $basket_item->amount = $basket_item->product->warehouse_amount > 0 ? $basket_item->product->warehouse_amount : 1;
                    $basket_item->save();
                    session()->flash('info_message', 'Množství u některých produktů bylo upraveno');
                }
            }
        }
        return $basket;
    }

    /**
     * Add product to basket and then redirect to basket page,
     * if item exists add only to amount
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function add(Request $request)
    {
        $request->validate([
            'product' => 'required|numeric',
            'amount' => 'required|numeric',
        ], [], [
            'product' => 'produkt',
            'amount' => 'množství'
        ]);
        $amount = (int) $request->amount;
        $basket = $this->get();
        $product = Product::find($request->product);
        if (empty($product)) {
            session()->flash('error_message', 'Zadaný produkt nebyl nalezen.');
            return redirect(route('basket'));
        }
        if ($basket_item = BasketItem::where(['basket_id' => $basket->id, 'product_id' => $product->id])->first()) {
            $basket_item->amount += $amount;
        } else {
            $basket_item = new BasketItem();
            $basket_item->amount = $amount;
            $basket_item->product()->associate($product);
        }
        if ($basket_item->amount > $product->warehouse_amount && $basket_item->amount !== 1) {
            session()->flash('info_message', 'Tolik kusů produktu "'. $product->full_name .'" není k dispozici. Do košíku bylo přidáno maximum');
            $basket_item->amount = $product->warehouse_amount > 0 ? $product->warehouse_amount : 1;
        }
        $basket->items()->save($basket_item);
        $basket->touch();
        $basket->save();
        session()->flash('success_message', 'Položka "'. $product->full_name .'" byla úspěšně přidána do košíku.');
        return redirect(route('basket'));
    }

    /**
     * Delete basket item from current basket
     * @param int $basket_item
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(int $basket_item) {
        $basket = $this->get();
        if($basket_item = BasketItem::where(['basket_id' => $basket->id, 'id' => $basket_item])->first()) {
            $basket_item->delete();
            session()->flash('success_message', 'Položka byla úspěšně odstraněna z košíku.');
            return redirect(route('basket'));
        } else {
            session()->flash('error_message', 'Nastala chyba.');
            return redirect(route('basket'));
        }
    }

    /**
     * Store form data by ajax request to session, so they persist for further use
     * @param Request $request
     * @return JsonResponse
     */
    public function storeFormData(Request $request): JsonResponse
    {
        if(!empty($request->key) && !empty($request->value)) {
            $basket_form = $request->session()->get('basket_form', []);
            $basket_form[$request->key] = $request->value;
            Session::put(['basket_form' => $basket_form]);
            return response()->json(['status' => 'ok']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    /**
     * Update basket item amount by ajax from basket page
     * @param Request $request
     * @return JsonResponse
     */
    public function updateBasketItem(Request $request): JsonResponse
    {
        $amount = (int) $request->amount;
        $basket = $this->get(false);
        if ($basket_item = BasketItem::where(['basket_id' => $basket->id, 'id' => $request->basket_item_id])->first()) {
            $basket_item->amount = $amount;
        } else {
            return response()->json(['status' => 'error', 'message' => 'Něco se nepovedlo.']);
        }
        if ($basket_item->amount > $basket_item->product->warehouse_amount && $basket_item->amount !== 1) {
            $basket_item->amount = $basket_item->product->warehouse_amount > 0 ? $basket_item->product->warehouse_amount : 1;
        }
        $basket->items()->save($basket_item);
        $basket->touch();
        $basket->save();
        return response()->json(['status' => 'ok', 'new_amount' => $basket_item->amount]);
    }
}
