<?php

namespace App\Http\Controllers;

use App\FilterMacros\PokemonFavoriteSearch;
use App\Http\Requests\AddPokemonFavoriteRequest;
use App\Http\Resources\PokemonDetailResource;
use App\Http\Resources\PokemonFavoriteResource;
use App\Http\Resources\PokemonResource;
use App\Models\PokemonFavorite;
use App\Services\PokemonService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseAlias;

class PokemonController extends Controller
{
    private PokemonService $pokeService;

    public function __construct(PokemonService $pokeService)
    {
        $this->pokeService = $pokeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 20);

        try {
            $result = $this->pokeService->getPokemons($page, $perPage);
            $dataResponse = $result['results'] ?? [];
            $totalData = $result['count'] ?? 0;

            $meta = ['totalData' => $totalData, 'page' => $page, 'perPage' => $perPage];

            return new PokemonResource(collect($dataResponse), $meta);

        } catch (\Exception $e) {
            return Response::responseError("failed get pokemon");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = $this->pokeService->getPokemon($id);
            return Response::responseSuccess(new PokemonDetailResource(collect($data)));

        } catch (\Exception $e) {
            return Response::responseError("failed get pokemon");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addFavorite(AddPokemonFavoriteRequest $request)
    {
        try {
            $data = $this->pokeService->addFavorite($request->pokemon_id);
            return Response::responseSuccess(['id' => $data->id]);

        } catch (\Exception $e) {
            return Response::responseError("failed add pokemon favorite");
        }
    }


    public function listFavorite(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 20);

        try {
            $poke = PokemonFavoriteSearch::apply($request);
            $poke = $poke->paginate($perPage, ['*'], 'page', $page);

            return PokemonFavoriteResource::collection($poke);
        } catch (\Exception $e) {
            return Response::responseError("failed get pokemon");
        }
    }


    public function listAbility(Request $request)
    {
        try {
            $poke = PokemonFavoriteSearch::apply($request)->pluck('abilities')->map(function ($item) {
                return json_decode($item);
            })->flatten()->unique()->values()->all();

            return Response::responseSuccess($poke);
        } catch (\Exception $e) {
            return Response::responseError("failed get pokemon");
        }
    }

    public function export()
    {
       $pokemons = PokemonFavorite::all();
        $data = [
            ['id', 'name'],
        ];

        foreach ($pokemons as $pokemon) {
            $data[] = [
                $pokemon->pokemon_id,
                $pokemon->name
            ];
        }

        $csvFileName = 'exported-data.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        );

        $handle = fopen('php://output', 'w');

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        return ResponseAlias::make('', 200, $headers);
    }

}
