<?php

namespace Tests\Feature\PokemonController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class showTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPokemonDetail(): void
    {
        $response = $this->get('/api/pokemons/2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data' => [
                    'id',
                    'name',
                    'height',
                    'abilities' => [
                        '*' => [
                            "id",
                            "name",
                            "is_hidden"
                        ]
                    ],
                    "species",
                    "types" => [
                        "*" => [
                            "id",
                            "name"
                        ]
                    ],
                    "status" => [
                        "*" => [
                            "id",
                            "name",
                            "base_stat",
                            "effort"
                        ]
                    ]
                ],
                "message"
            ]);;
    }
}
