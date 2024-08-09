<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Facade;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {   
        $this->json('POST', 'api/user/login')
            ->assertStatus(422)
            ->assertJson([
                'errors' =>[
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.']]]);
    }

    public function testUserLoginsSuccessfully()
    {
        $faker = \Faker\Factory::create();
        $email = $faker->email;

        $user = User::factory() ->create([
            'email' => $email,
            'password' => bcrypt('toptal123'),
        ]);

        $payload = ['email' => $email, 'password' => 'toptal123'];

        $this->json('POST', 'api/user/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token'
            ]);

    }
    
}
