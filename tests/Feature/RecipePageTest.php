<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Recipe;

class RecipePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_shows_recipes_for_logged_in_user(): void
    {
        $user = User::factory()->create();
        Recipe::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/recipes');

        $response->assertOk()->assertSee('Recipes');
    }

    public function test_redirects_guests_to_login(): void
    {
        $response = $this->get('/recipes');
        $response->assertRedirect('/login');
    }
}
