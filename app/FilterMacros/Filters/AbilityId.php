<?php

namespace App\FilterMacros\Filters;

use Illuminate\Database\Eloquent\Builder;

class AbilityId
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->whereJsonContains('abilities', [['id' => (int) $value]]);
    }
}
