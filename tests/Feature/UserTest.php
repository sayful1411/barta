<?php

use App\Models\Post;
use App\Models\User;

test('displays user profile with posts', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'testuser']);

    $posts = Post::factory()->count(5)->with_user()->create();

    $postMock = Mockery::mock(Post::class);
    $postMock->shouldReceive('with')->with(['user', 'media', 'comments'])->andReturnSelf();
    $postMock->shouldReceive('where')->with('user_id')->andReturn($user->id);
    $postMock->shouldReceive('orderByDesc')->with('created_at')->andReturnSelf();
    $postMock->shouldReceive('get')->andReturn($posts);

    app()->instance(Post::class, $postMock);

    // Act
    $response = $this->actingAs($user)
        ->get(route('users.profile', ['username' => $user->username]));

    // Assert
    $response->assertStatus(200)
        ->assertViewIs('pages.profiles.user-profile')
        ->assertViewHasAll([
            'user' => $user,
            'posts' => $posts,
            ]);

    Mockery::close();
});

test('handles 404 for non-existing user', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'testuser']);

    // Act
    $response = $this->actingAs($user)
        ->get(route('users.profile', ['username' => 'nonexistentuser']));

    // Assert
    $response->assertStatus(404);
});
