<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PokemonDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $abilities = $type = $status = [];
        $resources = $this->resource;
        $name = $resources['name'] ?? null;
        $height = $resources['height'] ?? null;
        $id = $resources['id'] ?? null;
        $species = $resources['species']["name"] ?? null;

        if (isset($resources['abilities'])) {
            $abilities = array_map(function ($item) {
                $path = explode('/', $item["ability"]['url']);
                $id = (int)$path[count($path) - 2];
                return [
                    'id' => $id,
                    "name" => $item["ability"]["name"] ?? null,
                    "is_hidden" => $item["is_hidden"] ?? null
                ];
            }, $resources['abilities']);
        }

        if (isset($resources['types'])) {
            $type = array_map(function ($item) {
                $path = explode('/', $item['type']['url']);
                $id = (int)$path[count($path) - 2];
                return [
                    'id' => $id,
                    'name' => $item['type']['name'],
                ];
            }, $resources['types']);
        }

        if (isset($resources['stats'])) {
            $status = array_map(function ($item) {
                $path = explode('/', $item["stat"]['url']);
                $id = (int)$path[count($path) - 2];
                return [
                    'id' => $id,
                    "name" => $item["stat"]["name"] ?? null,
                    "base_stat" => $item["base_stat"] ?? null,
                    "effort" => $item["effort"] ?? null
                ];
            }, $resources['stats']);
        }


        return [
            "id" => $id,
            "name" => $name,
            "height" => $height,
            "abilities" => $abilities,
            "species" => $species,
            "types" => $type,
            "status" => $status,
        ];
    }
}
