<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function userProfilePage($username){
        $user = DB::table("users")->where("username", $username)->first();

        if (empty($user)) {
            return abort(404);
        }

        // Check if the authenticated user matches the profile user
        $isUserProfile = Auth::check() && Auth::id() === $user->id;

        return view("pages.user-profile", compact("user","isUserProfile"));
    }

}
