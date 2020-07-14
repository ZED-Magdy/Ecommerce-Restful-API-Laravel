<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductRepository extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ProductRepository';
    }
}
