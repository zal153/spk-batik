<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('users are warned to reset password after 5 failed login attempts and redirected at 6', function () {
    $user = User::factory()->create();

    // 1st failed attempt
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);
    $response->assertSessionHas('login_attempts', 1);

    // 2nd, 3rd, 4th failed attempts
    for ($i = 2; $i <= 4; $i++) {
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $response->assertSessionHas('login_attempts', $i);
    }

    // 5th failed attempt
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);
    $response->assertSessionHas('login_attempts', 5);

    // 6th failed attempt - should redirect directly to forgot password
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);
    $this->assertGuest();
    $response->assertRedirect(route('password.request'));
});
