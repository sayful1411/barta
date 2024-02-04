<?php

use App\Models\Post;
use App\Models\User;
use Mockery;

it('can load the index page with posts', function () {

    $user = User::factory()->create();
    User::factory()->count(3)->create();
    $posts = Post::factory()->count(5)->with_user()->create();

    // Mock the Post model to return the test data
    $postMock = Mockery::mock(Post::class);
    $postMock->shouldReceive('with')->with(['user.media', 'media', 'comments'])->andReturnSelf();
    $postMock->shouldReceive('orderByDesc')->with('created_at')->andReturnSelf();
    $postMock->shouldReceive('get')->andReturn($posts);

    // dd($posts);

    app()->instance(Post::class, $postMock);

    $response = $this->actingAs($user)->get(route('index'));

    $response->assertViewIs('index')
        ->assertViewHas('posts', $posts);

    $this->assertDatabaseCount('posts', 5);
});
