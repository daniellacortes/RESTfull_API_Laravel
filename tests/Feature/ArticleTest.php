<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testsArticlesAreCreatedCorrectly()
    {
        $faker = Factory::create();

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
                'body' => $body
            ]);
    }

    public function testsArticlesAreDeletedCorrectly()
    {
        $faker = Factory::create();
        $title = $faker->sentence;
        $body = $faker->paragraph;

        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $article = Article::factory()->create();

        $this->json('DELETE', '/api/articles/' . $article->id, [])
            ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
        $article1 = Article::factory()->create();

        $article2 = Article::factory()->create();

        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $response = $this->json('GET', '/api/articles', [])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['title' => $article1->title, 'body' => $article1->body],
                    ['title' => $article2->title, 'body' => $article2->body]
                ]])
            ->assertJsonStructure([
                'data' => [['id', 'title', 'body', 'created_at', 'updated_at']],
            ]);
    }

    public function testArticlesAreUpdatedCorrectly()
    {
        $faker = Factory::create();

        $article1 = Article::factory()->create();

        $title = $faker->sentence;
        $body = $faker->paragraph;

        $payload = [
            'title' => $title,
            'body' => $body,
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $response = $this->json('PUT', '/api/articles/'.$article1->id, $payload)
            ->assertStatus(200)
            ->assertJson(['title' => $title, 'body' => $body]);
    }
}
