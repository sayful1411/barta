<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;

class LoginController extends Controller
{
    public function loginPage(){
        return view("auth.login");
    }

    public function login(UserLoginRequest $request){
        $credentials = $request->validated();

        $email = $credentials['email'];
        $password = $credentials['password'];

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('index');
        } else {
            return redirect()->back()->with('error', 'Login details are not valid');
        }

    }
}
