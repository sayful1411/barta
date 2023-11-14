<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage()
    {
        return view("auth.login");
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();

        $email = $credentials['email'];
        $password = $credentials['password'];

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->route('index');
        } else {
            return redirect()->back()->with('error', 'Login details are not valid');
        }

    }
}
