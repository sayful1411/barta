<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;

class RegisterController extends Controller
{
    public function registerPage(){
        return view("auth.register");
    }

    public function register(UserRegisterRequest $request){
        $validatedData = $request->validated();

        DB::table('users')->insert([
            'fname' => $validatedData['fname'],
            'lname' => $validatedData['lname'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success','Your registration has been successfully.');

    }
}
