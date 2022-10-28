<?php

namespace App\Providers;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        Model::shouldBeStrict(! $this->app->isProduction());

        if ($this->app->isProduction()) {
            DB::listen(static function ($query) {
                if (! str($query->sql)->startsWith('insert into "jobs"') && $query->time > 1000) {
                    logger()
                        ->channel('telegram')
                        ->warning(__('logging.db.query.longer'), [
                            'sql' => $query->sql,
                            'bindings' => $query->bindings,
                        ]);
                }
            });

            $this->app[HttpKernel::class]->whenRequestLifecycleIsLongerThan(
                5000,
                static function ($startedAt, Request $request) {
                    logger()
                        ->channel('telegram')
                        ->warning(__('logging.request.longer'), ['url' => $request->url()]);
                }
            );
        }
    }
}
