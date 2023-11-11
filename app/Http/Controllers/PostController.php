<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function store(PostRequest $request){
        $validatedPost = $request->validated();
        $userID = auth()->user()->id;

        DB::table("posts")->insert([
            "uuid" => (string) Str::uuid(),
            "user_id" => $userID,
            "description" => $validatedPost["barta"],
            "created_at" => now(),
            "updated_at" => now()
        ]);

        return redirect()->route("index")->with("success","Post Created");
    }
}
