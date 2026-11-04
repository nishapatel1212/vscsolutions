<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Driver
    |--------------------------------------------------------------------------
    |
    | Which SMS provider to send through. Defaults to "log", which writes
    | messages to the Laravel log instead of actually sending them — so the
    | feature (templates, recipient picker, send history) works before a
    | real provider is configured. Switch to 'twilio', 'clicksend', or
    | 'messagemedia' once you have credentials for one of them, and fill
    | in the matching block below via your .env file.
    |
    */

    'driver' => env('SMS_DRIVER', 'log'),

    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    'clicksend' => [
        'username' => env('CLICKSEND_USERNAME'),
        'api_key' => env('CLICKSEND_API_KEY'),
        // Falls back to the company_settings name at send time if unset — see ClickSendSmsDriver.
        'from' => env('CLICKSEND_FROM'),
    ],

    'messagemedia' => [
        'api_key' => env('MESSAGEMEDIA_API_KEY'),
        'api_secret' => env('MESSAGEMEDIA_API_SECRET'),
    ],

];
