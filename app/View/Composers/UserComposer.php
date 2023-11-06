<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class UserComposer{

    public function compose(View $view): void
    {
        $user = DB::table('users')->where('id', auth()->id())->first();
        $view->with("user",$user);
    }

}
