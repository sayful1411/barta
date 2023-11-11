<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserComposer{

    public function compose(View $view): void
    {
        $user = DB::table('users')->where('id', auth()->id())->first();
        $view->with("user",$user);
    }

}
