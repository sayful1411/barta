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

        $user = User::withCount('comments', 'posts')
                    ->with('posts.media', 'posts.comments')
                    ->where('fname',  $searchTerm)
                    ->orWhere('lname',  $searchTerm)
                    ->orWhere('username',  $searchTerm)
                    ->orWhere('email',  $searchTerm)
                    ->first();

        if($user == null){
            return view('404');
        }

        // Calculate total posts and comments
        $totalPosts = $user->posts_count;
        $totalComments = $user->comments_count;

        return view('pages.profiles.search-profile', compact('user', 'totalPosts', 'totalComments'));
    }
}
