<?php

declare(strict_types=1);

namespace App\Support;

use App\Support\CustomFields\ExporterBuilder;
use App\Support\CustomFields\FormBuilder;
use App\Support\CustomFields\ImporterBuilder;
use App\Support\CustomFields\InfolistBuilder;
use App\Support\CustomFields\TableBuilder;

final class CustomFields
{
    public static function form(): FormBuilder
    {
        return new FormBuilder;
    }

    public static function infolist(): InfolistBuilder
    {
        return new InfolistBuilder;
    }

    public static function table(): TableBuilder
    {
        return new TableBuilder;
    }

    public static function exporter(): ExporterBuilder
    {
        return new ExporterBuilder;
    }

    public static function importer(): ImporterBuilder
    {
        return new ImporterBuilder;
    }
}
