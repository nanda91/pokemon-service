<?php

namespace Tests\Feature\PokemonController;

use App\Models\PokemonFavorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class listFavoriteAbilityTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function setUp(): void
    {
        parent::setUp();
        PokemonFavorite::factory(2)->create();
    }
    /**
     * A basic feature test example.
     */
    public function testPokemonFavoriteList(): void
    {
        $response = $this->get('/api/pokemons/list-favorite-ability');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ]);;

        $responseJson = json_decode($response->content(), true);
        $this->assertEquals(2, count($responseJson['data']));
    }
}
