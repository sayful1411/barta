<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\UserSettingRequest;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $loggedInUserId = Auth::id();

        // $posts = DB::table('posts')
        //         ->join('users', 'posts.user_id', '=', 'users.id')
        //         ->select('posts.*', 'users.fname as user_fname', 'users.lname as user_lname', 'users.username as user_username','users.email as user_email')
        //         ->where('posts.user_id', $loggedInUserId)
        //         ->orderBy('id','desc')
        //         ->get();

        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            ->select(
                'posts.*',
                'users.fname as user_fname',
                'users.lname as user_lname',
                'users.username as user_username',
                'users.email as user_email',
                DB::raw('COUNT(comments.id) as comment_count')
            )
            ->groupBy(
                'posts.id',
                'posts.uuid',
                'posts.user_id',
                'posts.description',
                'posts.view_count',
                'posts.image',
                'posts.created_at',
                'posts.updated_at',
                'users.fname',
                'users.lname',
                'users.username',
                'users.email'
            )
            ->where('posts.user_id', $loggedInUserId)
            ->orderBy('posts.id', 'desc')
            ->get();

        $posts = $posts->map(function ($post) {
            $post->created_at = Carbon::parse($post->created_at);
            return $post;
        });

        return view("pages.profiles.profile", compact("posts"));
    }

    public function edit()
    {
        return view("pages.profiles.edit-profile");
    }

    public function profileSettingPage()
    {
        return view("pages.profiles.setting");
    }

    public function update(UserProfileRequest $request)
    {
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

    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/login');
    // }
}
