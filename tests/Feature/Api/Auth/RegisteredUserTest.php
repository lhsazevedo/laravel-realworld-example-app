<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisteredUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_user_with_token_on_valid_registration()
    {
        $data = [
            'user' => [
                'username' => 'test',
                'email' => 'test@test.com',
                'password' => 'topsecret',
            ]
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertOk()
            ->assertJson([
                'user' => [
                    'email' => 'test@test.com',
                    'username' => 'test',
                    'bio' => null,
                    'image' => null,
                ]
            ]);

        $this->assertArrayHasKey('token', $response->json('user'), 'Token not found');
    }
}
