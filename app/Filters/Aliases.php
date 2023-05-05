<?php

namespace App\Filters;

use CodeIgniter\Filters\Aliases as BaseAliases;

class FiltersAliases extends BaseAliases
{
    public static function filters(): array
    {
        return [
            'alpha_dash' => \CodeIgniter\Filters\URI::class,
        ];
    }

    public static function methods(): array
    {
        return [
            'alpha_dash' => 'setAlphaDash',
        ];
    }
}
