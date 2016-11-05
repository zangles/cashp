<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once __DIR__ . '/../Http/Helpers/Navigation.php';
        require_once __DIR__ . '/../Helpers/Downloader.php';
        require_once __DIR__ . '/../Helpers/ImageDownloader.php';
        require_once __DIR__ . '/../Helpers/PoringaDownloader.php';
        require_once __DIR__ . '/../Helpers/RusasDownloader.php';
    }
}
