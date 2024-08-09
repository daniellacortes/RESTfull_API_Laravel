<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testsRegistersSuccessfully()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $faker = \Faker\Factory::create();

        $payload = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => 'toptal123',
        ];

        $this->json('post', '/api/user', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
            ]);;
    }

    public function testsRequiresPasswordEmailAndName()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $this->json('post', '/api/user')
            ->assertStatus(422)
            ->assertJson([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }
}
