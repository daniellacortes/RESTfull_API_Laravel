<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function testsArticlesAreCreatedCorrectly()
    {
        $faker = \Faker\Factory::create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $title = $faker->sentence;
        $body = $faker->paragraph;

        $payload = [
            'title' => $title,
            'body' => $body,
        ];

        $this->json('POST', '/api/articles', $payload)
            ->assertStatus(201)
            ->assertJson([
                    'title' => $title,
                    'body' => $body]);
    }
}
