<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\Team;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

abstract class BaseExporter extends Exporter
{
    public function __construct(
        Export $export,
        array $columnMap,
        array $options,
    ) {
        parent::__construct($export, $columnMap, $options);
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    public static function modifyQuery(Builder $query): Builder
    {
        return $query;
    }
}
