<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PokemonResource extends BaseCustomPagination
{
    protected $meta;

    public function __construct($resource, $meta)
    {
        $this->meta = $meta;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return $this->populateDataSuccess(PokemonCollectionResource::collection($this->collection), $this->meta);
    }
}
