<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\UserSettingRequest;

class ProfileController extends Controller
{
    public function profilePage(){
        return view("pages.profile");
    }

    public function profileEditPage(){
        return view("pages.edit-profile");
    }

    public function profileSettingPage(){
        return view("pages.setting");
    }

    public function editProfile(UserProfileRequest $request){
        $validated = $request->validated();

        // get the authenticated user's id
        $userID = Auth::user()->id;

        // Update the user's information
        DB::table('users')
            ->where('id', $userID)
            ->update([
                'fname' => $validated['fname'],
                'lname' => $validated['lname'],
                'email' => $validated['email'],
                'bio' => $validated['bio'],
                'updated_at' => now(),
            ]);

        return redirect()->route('profile.edit')->with('success', 'User information updated successfully');
    }

    public function profileSetting(UserSettingRequest $request){
        $validated = $request->validated();

        // get the authenticated user's id and password
        $userID = Auth::user()->id;
        $userPassword = Auth::user()->password;

        if(!Hash::check($validated['current_password'], $userPassword)) {
            return redirect()->route('profile.setting')->with('error', 'Current password is not correct');
        }

        // If the current password is correct, update the user's password
        DB::table('users')
            ->where('id', $userID)
            ->update([
                'password' => Hash::make($validated['new_password']),
                'updated_at' => now(),
            ]);

        return redirect()->route('profile.setting')->with('success', 'Successfully changed password');
    }
}
