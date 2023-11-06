<?php

namespace Tests\Feature\PokemonController;

use App\Models\PokemonFavorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class listFavoriteTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function setUp(): void
    {
        parent::setUp();
        PokemonFavorite::factory()->create();
    }
    /**
     * A basic feature test example.
     */
    public function testPokemonFavoriteList(): void
    {
        $response = $this->get('/api/pokemons/list-favorite');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'pokemon_id',
                        'name',
                        'abilities' => [
                            '*' => [
                                'id',
                                'name',
                            ]
                        ]
                    ]
                ]
            ]);;

        $responseJson = json_decode($response->content(), true);
        $this->assertEquals(1, count($responseJson['data']));
    }
}
