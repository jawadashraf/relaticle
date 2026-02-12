<?php

declare(strict_types=1);

namespace App\Support\CustomFields\Support\Imports;

use Illuminate\Database\Eloquent\Model;
use WeakMap;

final class ImportDataStorage
{
    private static ?WeakMap $storage = null;

    private static function init(): void
    {
        self::$storage ??= new WeakMap;
    }

    public static function set(Model $record, string $fieldCode, mixed $value): void
    {
        self::init();

        $data = self::$storage[$record] ?? [];
        $data[$fieldCode] = $value;
        self::$storage[$record] = $data;
    }

    public static function pull(Model $record): array
    {
        self::init();

        $data = self::$storage[$record] ?? [];
        unset(self::$storage[$record]);

        return $data;
    }

    public static function has(Model $record): bool
    {
        self::init();

        return isset(self::$storage[$record]);
    }
}
