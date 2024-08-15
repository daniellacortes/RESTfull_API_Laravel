<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Support\Arr;
class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $faker = \Faker\Factory::create();

        $user = User::factory() ->create(['email' => $faker->email]);
        $token = $user->createToken('access_token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/logout', [], $headers)->assertStatus(202);
      
        $this->assertEquals(true, $user->tokens->isEmpty());
    }

    public function testUserWithNullToken()
    {
        $faker = \Faker\Factory::create();

        $user = User::factory() ->create(['email' => $faker->email]);

        $this->json('post', '/api/logout', [])->assertStatus(401);
    }
}
