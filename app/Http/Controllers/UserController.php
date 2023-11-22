<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index($username){
        $user = DB::table("users")->where("username", $username)->first();

        if (empty($user)) {
            return abort(404);
        }

        return view("pages.profiles.user-profile", compact("user"));
    }

}
