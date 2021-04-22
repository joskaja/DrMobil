<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DeliveryAndPaymentController extends Controller
{

    /**
     * Show all payment and delivery methods in admin
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.delivery-and-payment-methods', [
            'payment_methods' => PaymentMethod::all(),
            'delivery_methods' => DeliveryMethod::all()
        ]);
    }

    /**
     * Show add delivery method form in admin
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function addDeliveryMethod()
    {
        return view('admin.delivery-and-payment-method', [
            'delivery_and_payment_method' => new DeliveryMethod,
            'type' => 'delivery_method',
            'action' => route('admin.delivery_method.create')
        ]);
    }

    /**
     * Create new delivery method
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function createDeliveryMethod(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'string|max:255'
        ], [], [
            'name' => 'název',
            'price' => 'cena',
            'description' => 'popisek'
        ]);
        $delivery_method = new DeliveryMethod;
        $delivery_method->fill($request->all());
        $delivery_method->save();
        session()->flash('success_message', 'Nový způsob dopravy byl úspěšně přidán.');
        return redirect(route('admin.delivery_and_payment_methods'));
    }

    /**
     * Show edit delivery method form in admin
     * @param int $delivery
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function editDeliveryMethod(int $delivery)
    {
        $delivery_method = DeliveryMethod::findOrFail($delivery);
        return view('admin.delivery-and-payment-method', [
            'delivery_and_payment_method' => $delivery_method,
            'type' => 'delivery_method',
            'action' => route('admin.delivery_method.update', ['delivery' => $delivery_method])
        ]);
    }

    /**
     * Update delivery method
     * @param int $delivery
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function updateDeliveryMethod(int $delivery, Request $request)
    {
        $delivery_method = DeliveryMethod::findOrFail($delivery);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'string|max:255'
        ], [], [
            'name' => 'název',
            'price' => 'cena',
            'description' => 'popisek'
        ]);
        $delivery_method->fill($request->all());
        $delivery_method->save();
        session()->flash('success_message', 'Způsob dopravy byl úspěšně odstraněn.');
        return redirect(route('admin.delivery_and_payment_methods'));
    }

    /**
     * Delete delivery method
     * @param int $delivery
     * @return RedirectResponse
     */
    public function deleteDeliveryMethod(int $delivery): RedirectResponse
    {
        $delivery_method = DeliveryMethod::find($delivery);
        if ($delivery_method) {
            $delivery_method->delete();
            session()->flash('success_message', 'Způsob dopravy byl úspěšně odstraněn.');
        } else {
            session()->flash('error_message', 'Něco se nepovedlo');
        }
        return redirect()->back();
    }

    /**
     * Show add payment method form in admin
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function addPaymentMethod()
    {
        return view('admin.delivery-and-payment-method', [
            'delivery_and_payment_method' => new PaymentMethod,
            'type' => 'payment_method',
            'action' => route('admin.payment_method.create')
        ]);
    }

    /**
     * Create new payment method
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function createPaymentMethod(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'string|max:255'
        ], [], [
            'name' => 'název',
            'price' => 'cena',
            'description' => 'popisek'
        ]);
        $payment_method = new PaymentMethod;
        $payment_method->fill($request->all());
        $payment_method->save();
        session()->flash('success_message', 'Nový způsob platby byl úspěšně přidán.');
        return redirect(route('admin.delivery_and_payment_methods'));
    }

    /**
     * Show edit payment method form in admin
     * @param int $payment
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function editPaymentMethod(int $payment)
    {
        $payment_method = PaymentMethod::findOrFail($payment);
        return view('admin.delivery-and-payment-method', [
            'delivery_and_payment_method' => $payment_method,
            'type' => 'payment_method',
            'action' => route('admin.payment_method.update',['payment' => $payment_method->id])
        ]);
    }

    /**
     * Update payment method
     * @param int $payment
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function updatePaymentMethod(int $payment, Request $request)
    {
        $payment_method = PaymentMethod::findOrFail($payment);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'string|max:255'
        ], [], [
            'name' => 'název',
            'price' => 'cena',
            'description' => 'popisek'
        ]);
        $payment_method->fill($request->all());
        $payment_method->save();
        session()->flash('success_message', 'Způsob dopravy byl úspěšně odstraněn.');
        return redirect(route('admin.delivery_and_payment_methods'));
    }

    /**
     * Delete payment method
     * @param int $payment
     * @return RedirectResponse
     */
    public function deletePaymentMethod(int $payment): RedirectResponse
    {
        $payment_method = PaymentMethod::find($payment);
        if ($payment_method) {
            $payment_method->delete();
            session()->flash('success_message', 'Způsob dopravy byl úspěšně odstraněn.');
        } else {
            session()->flash('error_message', 'Něco se nepovedlo');
        }
        return redirect()->back();
    }
}
