<?php

namespace Adiazm\Addresses\Traits;

use Adiazm\Addresses\Models\Address;
use Adiazm\Addresses\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OwnsAddresses
 *
 * @property-read Collection|Address[]  $addresses
 * @property-read Collection|Contact[]  $contacts
 */
trait OwnsAddresses
{
    public function addresses(): HasMany
    {
        /** @var Model $this */
        return $this->hasMany(Address::class);
    }

    public function contacts(): HasMany
    {
        /** @var Model $this */
        return $this->hasMany(Contact::class);
    }

    /** @return Address[]|Collection */
    public function getBillingAddresses(): Collection|array
    {
        return $this->addresses()
            ->billing()
            ->get();
    }

    /** @return Address[]|Collection */
    public function getShippingAddresses(): Collection|array
    {
        return $this->addresses()
            ->shipping()
            ->get();
    }
}
