<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonFavorite extends Model
{
    use HasFactory;

    protected $cast = [
        'abilities' => 'array'
    ];

    protected  $fillable = ['name', 'pokemon_id', 'abilities'];
}
