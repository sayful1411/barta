<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Event;
use App\Events\CommentProcessed;

test('can not view comment page', function () {
    // Arrange
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    // Act
    $response = $this->actingAs($user)->get(route('posts.comments.index', $post->id));

    // Assert
    $response->assertStatus(404);
});

test('can comment and dispatches event', function () {
    // Arrange
    Event::fake();

    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id,
    ]);

    $commentData = [
        'user_id' => $post->user_id,
        'post_id' => $post->id,
        'comment' => 'Test comment',
    ];

    // Act
    $response = $this->actingAs($user)
        ->post(route('posts.comments.store', $post->id), $commentData);

    // Assert
    $response->assertRedirect(route('posts.show', $post->uuid))
        ->assertSessionHas('success', 'Comment Added');

    $this->assertDatabaseHas('comments', [
        'user_id' => 1,
        'post_id' => 1,
        'description' => 'Test comment',
    ]);

    $comment = Comment::where('user_id', $user->id)
        ->where('post_id', $post->id)
        ->where('description', $commentData['comment'])
        ->first();

    $this->assertNotNull($comment);

    Event::assertDispatched(CommentProcessed::class, function ($event) use ($comment) {
        return $event->comment->id === $comment->id;
    });
});

test('can view comment edit page', function () {
    // Arrange
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id' => $post->user_id,
        'post_id' => $post->id,
        'description' => 'Test comment',
    ]);

    $commentMock = Mockery::mock(Comment::class);
    $commentMock->shouldReceive('id')->with($comment->id)->andReturnSelf();
    $commentMock->shouldReceive('post_id')->with($post->id)->andReturnSelf();
    $commentMock->shouldReceive('firstOrFail')->andReturn($comment);

    app()->instance(Comment::class, $commentMock);

    // Act
    $response = $this->actingAs($user)->get(route('posts.comments.edit', [$post->id, $comment->id]));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('pages.comments.edit');
    $response->assertViewHasAll([
            'comment' => $comment
        ]);

    $this->assertDatabaseCount('comments', 1);
});

test('can not view comment edit page who not commented it', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id' => $otherUser->id,
        'post_id' => $post->id,
        'description' => 'Test comment',
    ]);

    $response = $this->actingAs($user)->get(route('posts.comments.edit', [$post->id, $comment->id]));

    $response->assertStatus(401);
});

test('can update a comment', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id' => $post->user_id,
        'post_id' => $post->id,
        'description' => 'Test comment',
    ]);

    $commentData = [
        'comment' => 'New comment',
    ];

    // Act
    $response = $this->actingAs($user)
        ->put(route('posts.comments.update', [$post->id, $comment->id]), $commentData);

    $response->assertRedirect(route('posts.show', $post->uuid))
        ->assertSessionHas('success', 'Comment updated');

    $this->assertDatabaseHas('comments', [
        'user_id' => 1,
        'post_id' => 1,
        'description' => 'New comment',
    ]);
});

test('can delete a comment', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id' => $post->user_id,
        'post_id' => $post->id,
        'description' => 'Test comment',
    ]);

    // Act
    $response = $this->actingAs($user)
        ->delete(route('posts.comments.destroy', [$post->id, $comment->id]));

    $response->assertRedirect(route('posts.show', $post->uuid))
        ->assertSessionHas('success', 'Comment deleted');

        $this->assertDatabaseMissing('comments', [
            'user_id' => 1,
            'post_id' => 1,
            'description' => 'Test comment',
        ]);
});

test('can not delete a comment who not commented it', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    $comment = Comment::factory()->create([
        'user_id' => $otherUser->id,
        'post_id' => $post->id,
        'description' => 'Test comment',
    ]);

    $response = $this->actingAs($user)->delete(route('posts.comments.destroy', [$post->id, $comment->id]));

    $response->assertStatus(401);
});
