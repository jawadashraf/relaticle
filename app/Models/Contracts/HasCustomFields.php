<?php

declare(strict_types=1);

namespace App\Models\Contracts;

use App\Models\CustomField;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasCustomFields
{
    public function customFieldValues(): MorphMany;

    public function getCustomFieldValue(CustomField $field): mixed;

    public function saveCustomFieldValue(CustomField $field, mixed $value): void;

    public function saveCustomFields(array $values, mixed $tenant = null): void;
}
