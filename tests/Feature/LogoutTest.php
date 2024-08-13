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
        
        $user->createToken('access_token');
        $array = $user->tokens[0];

        $token = Arr::get($array, 'token');

        dd($token);        

        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/articles', [], $headers)->assertStatus(200);
        $this->json('post', '/api/logout', [], $headers)->assertStatus(202);
        $this->json('get', '/api/articles', [], $headers)->assertStatus(401);
        
        $this->assertEquals(true, $user->tokens->isEmpty());

        // dd($user->tokens);

        // $this->assertNotEmpty($user->currentAccessToken());
    }

    // public function testUserWithNullToken()
    // {
    //     // // Simulating login
    //     // $user = factory(User::class)->create(['email' => 'user@test.com']);
    //     // $token = $user->generateToken();
    //     // $headers = ['Authorization' => "Bearer $token"];

    //     Sanctum::actingAs(
    //         $user = User::factory()->create(),
    //         ['view-tasks']
    //     );

    //     $user->user()->currentAccessToken()->delete();

    //     $this->json('post', '/api/logout', [])->assertStatus(401);
    // }
}
