<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

final class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        URL::macro('getAppUrl', function (string $path = ''): string {
            $baseUrl = config('app.url');

            return rtrim((string) $baseUrl, '/').'/'.ltrim($path, '/');
        });

        URL::macro('getPublicUrl', function (string $path = ''): string {
            $baseUrl = config('app.url');

            return rtrim((string) $baseUrl, '/').'/'.ltrim($path, '/');
        });
    }
}
