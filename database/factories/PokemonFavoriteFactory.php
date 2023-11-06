<?php

namespace Database\Factories;

use App\Models\PokemonFavorite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PokemonFavoriteFactory extends Factory
{
    protected $model = PokemonFavorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $abilities = [
            [
                "id" => $this->faker->randomDigit(),
                "name" => $this->faker->name
            ]
        ];
        return [
            'name' =>  $this->faker->name,
            'pokemon_id' => $this->faker->randomDigit(),
            'abilities' => json_encode($abilities)
        ];
    }
}
