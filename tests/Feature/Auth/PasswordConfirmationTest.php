<?php

use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Company::factory()->create(['slug' => 'main', 'active' => true, 'mobile' => '123456789']);
});

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('password.confirm', ['company' => 'main']));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('auth/ConfirmPassword'),
    );
});

test('password confirmation requires authentication', function () {
    $response = $this->get(route('password.confirm', ['company' => 'main']));

    $response->assertRedirect(route('login', ['company' => 'main']));
});
