<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        if (!App::runningInConsole()) {
            // Set the public path explicitly
            $publicPath = base_path('public_html/admin'); // change if your public folder is different
            $this->app->bind('path.public', fn() => $publicPath);

            $client = env('CLIENT_NAME');
            $logo = match ($client) {
                'vsc' => 'images/logo/vsc_logo.png',
                'latin' => 'images/logo/latin_logo.jpeg',
                default => 'images/logo/default.png',
            };

            Config::set('adminlte.logo_img', $logo);
        }
    }
}
