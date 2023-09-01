<?php

namespace Adiazm\Addresses\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Interface AddressableInterface
 * @package Adiazm\Addresses\Contracts
 */
interface AddressableInterface
{
    public function addresses(): MorphMany;
}
