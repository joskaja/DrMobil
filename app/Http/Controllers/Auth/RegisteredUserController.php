<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ], [], [
            'first_name' => 'jméno',
            'last_name' => 'přijmení',
            'email' => 'email',
            'password' => 'heslo'
        ]);
        $user = false;
        if ($validator->fails()) {
            if (!empty($validator->failed()['email']['Unique']) && User::where('email', $request->email)->where('active', false)->first()) {
                $user = User::where('email', $request->email)->where('active', false)->first();
            } else {
                return redirect('register')->withErrors($validator)->withInput();
            }
        }
        if(!$user) {
            Auth::login($user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'active' => true,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]));
        } else {
            $user->active = true;
            $user->password = Hash::make($request->password);
            $user->save();
        }
        event(new Registered($user));
        $redirect = !empty($user->admin) && $user->admin ? route('admin.dashboard') : route('user.profile.edit');
        return redirect($redirect);
    }
}
