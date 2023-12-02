<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $loggedInUserId = Auth::id();

        $posts = Post::withCount(['user', 'comments'])
            ->where('posts.user_id', $loggedInUserId)
            ->orderByDesc('created_at')
            ->get();

        // Calculate total comments
        $totalComments = $posts->sum('comments_count');

        return view("pages.profiles.profile", compact("posts", "totalComments"));
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

        $userID = Auth::user()->id;

        $user = User::find($userID);

        // Update user
        $user->update([
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'bio' => $validated['bio'],
        ]);

        if ($request->hasFile('avatar')) {
            // Delete previous avatar
            $user->clearMediaCollection('avatar');
            // generate new name
            $newFileName = Str::random(10) . time() . '.' . $request->file('avatar')->extension();
            // Add media to the media library
            $user->addMediaFromRequest('avatar')->usingFileName($newFileName)->toMediaCollection('avatar', 'profile_photos');
        }

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
