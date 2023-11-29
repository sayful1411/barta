<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $searchTerm = $request->input('search');

        $user = User::with('posts')->where('fname', 'like', '%' . $searchTerm . '%')
                    ->orWhere('lname', 'like', '%' . $searchTerm . '%')
                    ->orWhere('username', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->first();

        if($user == null){
            return view('404');
        }

        return view('pages.profiles.search-profile', compact('user'));
    }
}
