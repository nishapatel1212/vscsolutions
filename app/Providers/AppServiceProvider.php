<?php

namespace App\Providers;

use App\Contracts\SmsDriver;
use App\Services\Sms\ClickSendSmsDriver;
use App\Services\Sms\LogSmsDriver;
use App\Services\Sms\MessageMediaSmsDriver;
use App\Services\Sms\TwilioSmsDriver;
use Illuminate\Pagination\Paginator;
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
        $this->app->bind(SmsDriver::class, function () {
            return match (config('sms.driver', 'log')) {
                'twilio' => new TwilioSmsDriver(),
                'clicksend' => new ClickSendSmsDriver(),
                'messagemedia' => new MessageMediaSmsDriver(),
                default => new LogSmsDriver(),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
    }
}
