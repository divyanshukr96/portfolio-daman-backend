<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use League\Glide\ServerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('League\Glide\Server', function ($app){
            $filesystem = $app->make('Illuminate\Contracts\Filesystem\Filesystem');

            return ServerFactory::create([
                'source' => $filesystem->getdriver(),
                'cache' => $filesystem->getdriver(),
                'source_path_prefix' => 'images',
                'cache_path_prefix' => 'images/.cache',
//                'driver' => 'imagick',
                'max_image_size' => 2000*2000,
                'presets' => [
                    'thumbnail' => [
                        'w' => 300,
                        'h' => 300,
                        'fit' => 'crop',
                    ]
                ]
            ]);
        });
    }
}
