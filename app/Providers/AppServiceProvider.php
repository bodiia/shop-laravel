<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::shouldBeStrict(! app()->isProduction());

        if (app()->isProduction()) {
            DB::listen(static function ($query) {
                if ($query->time > 1000) {
                    logger()
                        ->channel('telegram')
                        ->debug('Query execution so long: ' . $query->sql, $query->bindings);
                }
            });

            DB::whenQueryingForLongerThan(
                CarbonInterval::second(5),
                static function (Connection $connection) {
                    logger()
                        ->channel('telegram')
                        ->debug('whenQueryingForLongerThan: ' . $connection->totalQueryDuration());
                }
            );

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::second(4),
                static function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
                }
            );
        }
    }
}
