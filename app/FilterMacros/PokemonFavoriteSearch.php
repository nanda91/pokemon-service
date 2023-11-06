<?php


namespace App\FilterMacros;

use App\Models\PokemonFavorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class PokemonFavoriteSearch
{
    public static function apply(Request $filters)
    {

        return static::applyDecoratorsFromRequest($filters, (new PokemonFavorite())
            ->newQuery()
        );
    }

    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' . Str::studly($name);
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }
}
