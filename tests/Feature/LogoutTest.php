<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        // $faker = \Faker\Factory::create();

        // $user = User::factory() ->create(['email' => $faker->email]);
        // $token = $user->generateToken();
        // $headers = ['Authorization' => "Bearer $token"];

        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

        $this->json('get', '/api/articles', [])->assertStatus(200);
        $this->json('post', '/api/logout', [])->assertStatus(202);

        $this->assertEquals(null, $user->api_token);
    }
}
