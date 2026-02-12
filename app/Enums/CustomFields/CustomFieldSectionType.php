<?php

declare(strict_types=1);

namespace App\Enums\CustomFields;

enum CustomFieldSectionType: string
{
    case SECTION = 'section';
    case HEADLESS = 'headless';
}
