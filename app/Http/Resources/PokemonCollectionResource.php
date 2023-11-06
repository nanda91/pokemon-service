<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PokemonCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $id = null;
        if (isset($this['url'])) {
            $path = explode('/', $this['url']);
            $id = (int)$path[count($path) - 2];
        }

        return [
            'id' => $id,
            'name' => $this['name'] ?? null,
        ];
    }
}
