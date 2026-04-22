<?php

use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::registration());
});

test('registration screen can be rendered', function () {
    $response = $this->get(route('register', ['company' => 'main']));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store', ['company' => 'main']), [
        'name' => 'Test User',
        'email' => 'test-unique-' . uniqid() . '@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', ['company' => 'main'], absolute: false));
});
