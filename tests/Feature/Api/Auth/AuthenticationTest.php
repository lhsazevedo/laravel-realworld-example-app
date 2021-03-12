<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_authenticates_an_user()
    {
        $data = [
            'user' => [
                'email' => $this->user->email,
                'password' => 'password',
            ]
        ];

        $response = $this->postJson('/api/users/login', $data);

        $response->assertOk()
            ->assertJson([
                'user' => [
                    'email' => $this->user->email,
                    'username' => $this->user->username,
                    'bio' => null,
                    'image' => null,
                ]
            ]);

        $this->assertArrayHasKey('token', $response->json('user'), 'Token not found');
    }
}
