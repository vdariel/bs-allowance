<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

pest()->use(DatabaseTransactions::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard', ['company' => 'main']));
    $response->assertRedirect(route('login', ['company' => 'main']));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard', ['company' => 'main']));
    $response->assertOk();
});
