<?php

namespace Adiazm\Addresses\Traits;

use Adiazm\Addresses\Exceptions\FailedValidationException;
use Adiazm\Addresses\Models\Contact;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class HasContacts
 *
 * @property Collection|Contact[]  $contacts
 */
trait HasContacts
{
    public function contacts(): MorphMany
    {
        /** @var Model $this */
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function hasContacts(): bool
    {
        return $this->contacts->isNotEmpty();
    }

    /** @throws Exception */
    public function addContact(array $attributes): Contact|Model
    {
        $attributes = $this->loadContactAttributes($attributes);

        return $this->contacts()->updateOrCreate($attributes);
    }

    /** @throws Exception */
    public function updateContact(Contact $contact, array $attributes): bool
    {
        $attributes = $this->loadContactAttributes($attributes);

        return $contact->fill($attributes)->save();
    }

    /** @throws Exception */
    public function deleteContact(Contact $contact): bool
    {
        if ($this !== $contact->contactable()->first()) {
            return false;
        }

        return $contact->delete();
    }

    public function flushContacts(): bool
    {
        return $this->contacts()->delete();
    }

    /** @throws FailedValidationException */
    public function loadContactAttributes(array $attributes): array
    {
        // run validation
        $validator = $this->validateContact($attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $error = '[Addresses] '.implode(' ', $errors);

            throw new FailedValidationException($error);
        }

        return $attributes;
    }

    public function validateContact(array $attributes): Validator
    {
        $rules = Contact::getValidationRules();

        return validator($attributes, $rules);
    }
}
