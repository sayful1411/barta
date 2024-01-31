<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


test('can post without image', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('posts.store'), [
            "uuid" => (string) Str::uuid(),
            "user_id" => $user->id,
            "barta" => 'demo description',
        ]);

    $response->assertRedirect(route('index'));
    $response->assertSessionHas('success', 'Post Created');

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'description' => 'demo description',
    ]);

    $this->assertDatabaseCount('users', 1);
});

test('can post with image', function () {
    $user = User::factory()->create();

    config()->set('filesystems.disks.media', [
        'driver' => 'local',
        'root' => __DIR__.'/../../temp',
    ]);

    config()->set('medialibrary.default_filesystem', 'media');


    $imageFile = UploadedFile::fake()->image('test_image.jpg');

    $response = $this
        ->actingAs($user)
        ->post(route('posts.store'), [
            "uuid" => (string) Str::uuid(),
            "user_id" => $user->id,
            "barta" => 'demo description',
            "picture" => $imageFile,
        ]);

    $response->assertRedirect(route('index'));

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'description' => 'demo description',
    ]);

    $post = Post::where('user_id', $user->id)->where('description', 'demo description')->first();

    $this->assertFileExists($post->getFirstMedia('post_image')->getPath());
});

test('can not upload images larger than 2 megapixels', function () {
    $user = User::factory()->create();

    // Mock file upload
    Storage::fake('post_images');

    $imageFile = UploadedFile::fake()->image('test_image.jpg')->size(2049);

    $response = $this
        ->actingAs($user)
        ->post(route('posts.store'), [
            "uuid" => (string) Str::uuid(),
            "user_id" => $user->id,
            "barta" => 'demo description',
            "picture" => $imageFile,
        ]);

    $response->assertRedirect(route('index'));

    $response->assertSessionHasErrors([
        'picture' => 'The picture field must not be greater than 2000 kilobytes.'
    ]);

});

test('can not post without description', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/posts', [
            "uuid" => (string) Str::uuid(),
            "user_id" => $user->id,
            "barta" => NULL,
        ]);

    $response->assertRedirect(route('index'));
    $response->assertSessionHasErrors([
        'barta' => 'The barta field is required.'
    ]);
});

test('can not post more than 280 characters for description', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/posts', [
            "uuid" => (string) Str::uuid(),
            "user_id" => $user->id,
            "barta" => Str::repeat('a', 281),
        ]);

    $response->assertRedirect(route('index'));
    $response->assertSessionHasErrors([
        'barta' => 'The barta field must not be greater than 280 characters.'
    ]);
});

test('can view a single post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    $comments = Comment::factory(3)->create([
        'user_id' => $user->id,
        'post_id' => $post->id
    ]);

    $postMock = Mockery::mock(Post::class);
    $postMock->shouldReceive('with')->with(['user'])->andReturnSelf();
    $postMock->shouldReceive('uuid')->with($post->uuid)->andReturnSelf();
    $postMock->shouldReceive('firstOrFail')->andReturn($post);

    $commentMock = Mockery::mock(Comment::class);
    $commentMock->shouldReceive('with')->with(['user'])->andReturnSelf();
    $commentMock->shouldReceive('post_id')->with($post->id)->andReturnSelf();
    $commentMock->shouldReceive('get')->andReturn($comments);

    app()->instance(Post::class, $postMock);
    app()->instance(Comment::class, $commentMock);

    $response = $this->actingAs($user)->get(route('posts.show', $post->uuid));

    $response->assertStatus(200);
    $response->assertViewIs('pages.posts.single-posts');
    $response->assertViewHasAll([
            'post' => $post,
            'comments' => $comments,
        ]);

    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseCount('posts', 1);
    $this->assertDatabaseCount('comments', 3);
    $this->assertDatabaseHas('posts',['views_count' => $post->views_count + 1]);
});

test('can view post edit page who posted it', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    $postMock = Mockery::mock(Post::class);
    $postMock->shouldReceive('uuid')->with($post->uuid)->andReturnSelf();
    $postMock->shouldReceive('firstOrFail')->andReturn($post);

    app()->instance(Post::class, $postMock);

    $response = $this->actingAs($user)->get(route('posts.edit', $post->uuid));

    $response->assertStatus(200);
    $response->assertViewIs('pages.posts.edit');
    $response->assertViewHasAll(['post' => $post]);

    $this->assertDatabaseCount('posts', 1);
});

test('can not view post edit page who not posted it', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $otherUser->id
    ]);

    $response = $this->actingAs($user)->get(route('posts.edit', $post->uuid));

    $response->assertStatus(302);
    $response->assertRedirect(route('index'));

});

test('can update post without image', function () {
    // Arrange
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);
    $newDescription = 'Updated description';

    // Act
    $response = $this->actingAs($user)
        ->patch(route('posts.update', $post->uuid), [
            'barta' => $newDescription,
        ]);

    // Assert
    $response->assertRedirect(route('posts.edit', $post->uuid));
    $response->assertSessionHas('success', 'Post Updated');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'description' => $newDescription,
    ]);

});

test('can update post and clears previous image if a new picture is provided', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);
    $newDescription = 'Updated description';

    $post->addMediaFromUrl('https://via.placeholder.com/150')->toMediaCollection('post_image', 'post_images');
    $oldPath = $post->getFirstMedia('post_image')->getPath();

    config()->set('filesystems.disks.media', [
        'driver' => 'local',
        'root' => __DIR__.'/../../temp',
    ]);

    config()->set('medialibrary.default_filesystem', 'media');


    $newImageFile = UploadedFile::fake()->image('test_image.jpg');

    $response = $this->actingAs($user)
        ->patch(route('posts.update', $post->uuid), [
            'barta' => $newDescription,
            "picture" => $newImageFile,
        ]);

    // Assert
    $response->assertRedirect(route('posts.edit', $post->uuid));
    $response->assertSessionHas('success', 'Post Updated');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
    ]);

    $post = Post::where('user_id', $user->id)->first();

    $this->assertFileExists($post->getFirstMedia('post_image')->getPath());
    $this->assertFileDoesNotExist($oldPath);
});

test('can delete post', function () {
    // Create a user
    $user = User::factory()->create();

    // Create a post
    $post = Post::factory()->create([
        'user_id' => $user->id
    ]);

    // Acting as the user, try to delete the post
    $response = $this
        ->actingAs($user)
        ->delete(route('posts.destroy', $post));

    // Check if the response status and redirection are as expected
    $response->assertRedirect(route('index'));
    $response->assertStatus(302);

    // Check if the post has been deleted from the database
    $this->assertDatabaseMissing('posts', ['id' => $post->id]);

    // Check if the 'success' session variable is set
    $response->assertSessionHas('success', "Post deleted");
});

