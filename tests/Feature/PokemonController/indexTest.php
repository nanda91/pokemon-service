<?php

namespace Tests\Feature\PokemonController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class indexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPokemonList(): void
    {
        $response = $this->get('/api/pokemons');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ]);;
    }
}
