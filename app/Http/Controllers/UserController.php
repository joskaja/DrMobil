<?php


namespace App\Http\Controllers;


use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * List all users in admin view
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.users', [
            'users' => User::orderBy('created_at', 'desc')->get()
        ]);

    }


    /**
     * Show edit user form in admin
     * @param int $user
     * @return \Illuminate\Contracts\View\View|View
     */
    public function edit()
    {
        $user = Auth::user();
        return view('eshop.user', [
            'user' => $user,
            'address' => Address::find($user->address_id) ?? new Address,
        ]);
    }

    /**
     * Edit user in admin
     * @param int $user
     * @return \Illuminate\Contracts\View\View|View
     */
    public function adminEdit(int $user)
    {
        $user = User::findOrFail($user);
        return view('admin.user', [
            'user' => $user,
            'address' => Address::find($user->address_id) ?? new Address,
            'action' => route('admin.users.update', $user->id)
        ]);
    }

    /**
     * Update users data in admin
     * @param int $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(int $user, Request $request): RedirectResponse
    {
        $user = User::findOrFail($user);
        if (Auth::user()->admin || (Auth::user()->is($user))) {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id)
                ],
                'street' => 'nullable|string|max:255',
                'house_number' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|regex:^\d{5}(?:[-\s]\d{4})?$^|max:255',
            ], [], [
                'first_name' => 'jméno',
                'last_name' => 'přijmení',
                'email' => 'e-mail',
                'street' => 'ulice',
                'house_number' => 'číslo popisné',
                'city' => 'město',
                'zip_code' => 'PSČ'
            ]);
            if (!empty($request->active)) {
                $user->active = $request->active === 'on';
            }
            if (!empty($request->admin)) {
                $user->admin = $request->admin === 'on';
            }
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            if (!empty($request->street) || !empty($request->house_number) || !empty($request->city) || !empty($request->zip_code)) {
                $address = new Address();
                if (!empty($user->address)) {
                    $address = $user->address;
                }
                $address->street = $request->street;
                $address->house_number = $request->house_number;
                $address->city = $request->city;
                $address->zip_code = $request->zip_code;
                $address->save();
                $user->address_id = $address->id;
            }
            $user->save();
            session()->flash('success_message', 'Uživatel byl úspěšně upraven.');
            $url = url()->previous();
            $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
            $new_route = str_contains($route, 'admin') ? route('admin.users') : route('user.profile.edit');
            return redirect($new_route);
        } else {
            return redirect(route('home'));
        }
    }

    /**
     * Delete users account
     * @param int $user
     * @return RedirectResponse
     */
    public function delete(int $user): RedirectResponse
    {
        $user = User::find($user);
        if ($user) {
            $user->delete();
            session()->flash('success_message', 'Uživatel byl úspěšně odstraněn');
        } else {
            session()->flash('error_message', 'Něco se nepovedlo');
        }
        return redirect()->back();
    }
}
