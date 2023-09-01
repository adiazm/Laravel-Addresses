<?php

namespace Adiazm\Addresses\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Address
 * @package Adiazm\Addresses\Facades
 */
class Address extends Facade
{
    /** @inheritdoc */
    protected static function getFacadeAccessor(): string
    {
        return 'address';
    }
}
