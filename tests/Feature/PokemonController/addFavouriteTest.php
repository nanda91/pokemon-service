<?php

namespace Tests\Feature\pokemonController;

use App\Models\PokemonFavorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class addFavouriteTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function testAddFavouriteTestSuccess()
    {

        $input = [
            "pokemon_id" => 6
        ];

        $url = "/api/pokemons/add-favorite";
        $response = $this->post($url, $input);

        if ($response->status() != 200) {
            dd($response);
        }

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id'
                ],
                'message'
            ]);

        $responseJson = json_decode($response->content(), true);
        $this->assertEquals("OK", $responseJson['message']);
        $data = $responseJson['data'];

        $pokemon = PokemonFavorite::find($data['id']);
        $this->assertEquals($input['pokemon_id'], $pokemon->pokemon_id);
    }

    public function testAddFavouriteTestFailedRequired()
    {

        $input = [];

        $url = "/api/pokemons/add-favorite";
        $response = $this->post($url, $input);

        $response->assertStatus(400)
            ->assertJsonStructure([
                'error',
                'data' => [
                    'pokemon_id'
                ],
                'message'
            ]);

        $responseJson = json_decode($response->content(), true);
        $this->assertEquals(true, $responseJson['error']);
        $this->assertEquals('The given data was invalid.', $responseJson['message']);
        $data = $responseJson['data'];

        $this->assertIsArray($data['pokemon_id']);
    }
}
