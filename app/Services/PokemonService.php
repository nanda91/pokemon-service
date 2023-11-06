<?php
namespace App\Services;

use App\Models\PokemonFavorite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PokemonService
{
    private function apiResponse($apiResponse)
    {
        if ($apiResponse->successful() || $apiResponse->status() == 400) {
            return $apiResponse->json();
        }

        return $apiResponse->throw();
    }


    public function getPokemons($page, $perPage)
    {
        return Cache::remember('api_list_data', 100, function () use ($page, $perPage) {
            $url = "https://pokeapi.co/api/v2/pokemon?offset={$page}&limit={$perPage}";
            $apiResponse = Http::get($url);
            return $this->apiResponse($apiResponse);
        });

    }

    public function getPokemon($id)
    {
        return Cache::remember('api_detail_data', 100, function () use($id) {
            $url = "https://pokeapi.co/api/v2/pokemon/{$id}";
            $apiResponse = Http::get($url);
            return $this->apiResponse($apiResponse);
        });
    }

    public function addFavorite($id)
    {
        Cache::forget('api_detail_data');

        $response = $this->getPokemon($id);
        if ($response) {
            $abilities = [];
            $name = $response['name'] ?? null;

            if (isset($response['abilities'])) {
                $abilities = array_map(function ($item) {
                    $path = explode('/', $item["ability"]['url']);
                    $id = (int)$path[count($path) - 2];
                    return [
                        'id' => $id,
                        "name" => $item["ability"]["name"] ?? null
                    ];
                }, $response['abilities']);
            }

            $data = [
                "pokemon_id" => $id,
                "name" => $name,
                "abilities" => json_encode($abilities),
            ];
            return PokemonFavorite::create($data);
        }
        return null;
    }
}
