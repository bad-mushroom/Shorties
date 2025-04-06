<?php

namespace BadMushroom\Shorties\Facades;

use Illuminate\Support\Facades\Facade;

class Shorty extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shorties';
    }
}
