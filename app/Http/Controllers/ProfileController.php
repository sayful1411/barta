<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $loggedInUserId = Auth::id();

        $posts = Post::with(['user', 'comments'])
            ->where('posts.user_id', $loggedInUserId)
            ->orderByDesc('created_at')
            ->get();

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

        User::where('id', $userID)->update([
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'bio' => $validated['bio']
        ]);

        return redirect()->back()->with('success', 'User information updated successfully');
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
