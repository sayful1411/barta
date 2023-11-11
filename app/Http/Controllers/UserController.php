<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function userProfilePage($username){
        $user = DB::table("users")->where("username", $username)->first();

        if (empty($user)) {
            return abort(404);
        }

        return view("pages.user-profile", compact("user"));
    }

}
