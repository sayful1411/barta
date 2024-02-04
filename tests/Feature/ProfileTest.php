<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('edit profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/edit-profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/update-profile', [
            'fname' => 'Test',
            'lname' => 'User',
            'email' => 'test@example.com',
            'bio' => 'user bio'
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/edit-profile');

    $user->refresh();

    $this->assertSame('Test', $user->fname);
    $this->assertSame('User', $user->lname);
    $this->assertSame('test@example.com', $user->email);
    $this->assertSame('user bio', $user->bio);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/update-profile', [
            'fname' => 'Test',
            'lname' => 'User',
            'email' => $user->email,
            'bio' => 'user bio',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/edit-profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

// test('user can delete their account', function () {
//     $user = User::factory()->create();

//     $response = $this
//         ->actingAs($user)
//         ->delete('/profile', [
//             'password' => 'password',
//         ]);

//     $response
//         ->assertSessionHasNoErrors()
//         ->assertRedirect('/');

//     $this->assertGuest();
//     $this->assertNull($user->fresh());
// });

// test('correct password must be provided to delete account', function () {
//     $user = User::factory()->create();

//     $response = $this
//         ->actingAs($user)
//         ->from('/profile')
//         ->delete('/profile', [
//             'password' => 'wrong-password',
//         ]);

//     $response
//         ->assertSessionHasErrorsIn('userDeletion', 'password')
//         ->assertRedirect('/profile');

//     $this->assertNotNull($user->fresh());
// });
