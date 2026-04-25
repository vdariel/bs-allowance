<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

pest()->use(DatabaseTransactions::class);

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('profile.edit', ['company' => 'main']));

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $newEmail = fake()->unique()->safeEmail;
    $response = $this
        ->actingAs($user)
        ->patch(route('profile.update', ['company' => 'main']), [
            'name' => 'Test User',
            'email' => $newEmail,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.edit', ['company' => 'main']));

    $user->refresh();

    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe($newEmail);
    expect($user->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('profile.update', ['company' => 'main']), [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.edit', ['company' => 'main']));

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete(route('profile.destroy', ['company' => 'main']), [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('home'));

    $this->assertGuest();
    expect($user->fresh())->toBeNull();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from(route('profile.edit', ['company' => 'main']))
        ->delete(route('profile.destroy', ['company' => 'main']), [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect(route('profile.edit', ['company' => 'main']));

    expect($user->fresh())->not->toBeNull();
});
