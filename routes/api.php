<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('pokemons/add-favorite', [PokemonController::class, 'addFavorite']);
Route::get('pokemons/list-favorite', [PokemonController::class, 'listFavorite']);
Route::get('pokemons/list-favorite-ability', [PokemonController::class, 'listAbility']);
Route::get('pokemons/export', [PokemonController::class, 'export']);
Route::apiResources(['pokemons' => PokemonController::class]);

