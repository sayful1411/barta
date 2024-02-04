<?php

use App\Models\Post;
use App\Models\User;

test('searches for a user and displays the profile', function () {
    // Arrange
    $searchTerm = 'John';

    $user = User::factory()->hasPosts(5)->hasComments(10)->create([
        'id' => 1,
        'fname' => 'John',
        'lname' => 'Doe',
        'username' => 'johndoe',
        'email' => 'john@example.com',
    ]);

    // Mock the User model
    $userMock = Mockery::mock(User::class);
    $userMock->shouldReceive('withCount')->with(['comments', 'posts'])->andReturnSelf();
    $userMock->shouldReceive('with')->with(['posts.media', 'posts.comments'])->andReturnSelf();
    $userMock->shouldReceive('where')->with('fname', $searchTerm)->andReturnSelf();
    $userMock->shouldReceive('orWhere')->with('lname', $searchTerm)->andReturnSelf();
    $userMock->shouldReceive('orWhere')->with('username', $searchTerm)->andReturnSelf();
    $userMock->shouldReceive('orWhere')->with('email', $searchTerm)->andReturnSelf();
    $userMock->shouldReceive('first')->andReturn($user);

    // Bind the mock instance to the container
    $this->app->instance(User::class, $userMock);

    $authUser = User::factory()->create();

    // Act
    $response = $this->actingAs($authUser)->get(route('search.user', ['search' => $searchTerm]));

    // Assert
    $response->assertStatus(200)
        ->assertViewIs('pages.profiles.search-profile')
        ->assertViewHas('user')
        ->assertViewHas('totalPosts', 5)
        ->assertViewHas('totalComments', 10);
});

test('handles 404 for non-existing user', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $response = $this->actingAs($user)->get(route('search.user', ['search' => 'NonExistentUser']));

    // Assert
    $response->assertStatus(404);
});

// Cleanup after each test
afterEach(function () {
    Mockery::close();
});
