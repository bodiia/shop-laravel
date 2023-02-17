<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use Support\Testing\FakerImageProvider;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;

class TestingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new FakerImageProvider(
                $faker,
                app(Filesystem::class)
            ));

            return $faker;
        });
    }

    public function boot()
    {
        //
    }
}
