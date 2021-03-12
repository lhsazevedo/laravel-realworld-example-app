<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_valid_profile()
    {
        $response = $this->getJson("/api/profiles/{$this->user->username}");

        $response->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $this->user->username,
                    'bio' => $this->user->bio,
                    'image' => $this->user->image,
                    'following' => false,
                ]
            ]);
    }

    public function test_it_returns_a_not_found_error_on_invalid_profile()
    {
        $response = $this->getJson('/api/profiles/somerandomusername');

        $response->assertNotFound();
    }

    public function test_it_returns_the_profile_following_property_accordingly_when_followed_and_unfollowed()
    {
        $response = $this->postJson("/api/profiles/{$this->user->username}/follow", [], $this->headers);

        $response->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $this->user->username,
                    'bio' => $this->user->bio,
                    'image' => $this->user->image,
                    'following' => true,
                ]
            ]);

        $this->assertTrue($this->loggedInUser->isFollowing($this->user), 'Failed to follow user');

        $response = $this->deleteJson("/api/profiles/{$this->user->username}/follow", [], $this->headers);

        $response->assertOk()
            ->assertJson([
                'profile' => [
                    'username' => $this->user->username,
                    'bio' => $this->user->bio,
                    'image' => $this->user->image,
                    'following' => false,
                ]
            ]);

        $this->assertFalse($this->loggedInUser->isFollowing($this->user), 'Failed to unfollow user');
    }

    public function test_it_returns_a_not_found_error_when_trying_to_follow_and_unfollow_an_invalid_user()
    {
        $response = $this->postJson("/api/profiles/somerandomusername/follow", [], $this->headers);

        $response->assertNotFound();

        $response = $this->deleteJson("/api/profiles/somerandomusername/follow", [], $this->headers);

        $response->assertNotFound();
    }

    public function test_it_returns_an_unauthorized_error_when_trying_to_follow_or_unfollow_without_logging_in()
    {
        $response = $this->postJson("/api/profiles/{$this->user->username}/follow");

        $response->assertUnauthorized();

        $response = $this->deleteJson("/api/profiles/{$this->user->username}/follow");

        $response->assertUnauthorized();
    }
}
