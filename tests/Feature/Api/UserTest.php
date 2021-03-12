<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_current_user()
    {
        $response = $this->getJson('/api/user', $this->headers);

        $response->assertOk()
            ->assertJson([
                'user' => [
                    'email' => $this->loggedInUser->email,
                    'username' => $this->loggedInUser->username,
                    'bio' => $this->loggedInUser->bio,
                    'image' => $this->loggedInUser->image,
                ]
            ]);
    }

    public function test_it_returns_invalid_token_error_when_using_a_wrong_token()
    {
        $this->markTestSkipped();

        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer InsertWrongTokenHereToTestPleaseSendHelp'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => 'JWT error: Token is invalid',
                ]
            ]);
    }

    public function test_it_returns_an_unauthorized_error_when_not_logged_in()
    {
        $this->markTestSkipped();

        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_it_returns_the_updated_user_on_updating()
    {
        $data = [
            'user' => [
                'username' => 'test12345',
                'email' => 'test12345@test.com',
                'password' => 'test12345',
                'bio' => 'hello',
                'image' => 'http://test.com/test.jpg',
            ]
        ];

        $response = $this->putJson('/api/user', $data, $this->headers);

        $response->assertOk()
            ->assertJson([
                'user' => [
                    'username' => 'test12345',
                    'email' => 'test12345@test.com',
                    'bio' => 'hello',
                    'image' => 'http://test.com/test.jpg',
                ]
            ]);

        $this->assertTrue(Hash::check(
            $data['user']['password'], $this->loggedInUser->fresh()->password
        ));
        // $this->assertTrue(auth()->once($data['user']), 'Password update failed');
    }
}
