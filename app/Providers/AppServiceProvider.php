<?php

namespace App\Providers;

use App\Faker\FakerImageProvider;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new FakerImageProvider($faker));

            return $faker;
        });
    }

    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());

        if ($this->app->isProduction()) {
            DB::listen(static function ($query) {
                if (! str($query->sql)->startsWith('insert into "jobs"') && $query->time > 1000) {
                    logger()
                        ->channel('telegram')
                        ->warning('An individual database query exceeded 1 second.', [
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
                        ->warning('A request took longer than 5 seconds.', ['url' => $request->url()]);
                }
            );
        }
    }
}
