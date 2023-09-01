<?php

namespace Adiazm\Addresses\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Interface AddressableInterface
 */
interface AddressableInterface
{
    public function addresses(): MorphMany;
}
