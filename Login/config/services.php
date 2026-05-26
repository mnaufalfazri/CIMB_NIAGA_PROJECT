<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Microservice URLs & Internal Secret
    |--------------------------------------------------------------------------
    */

    'regist' => [
        'url' => env('REGIST_SERVICE_URL', 'http://localhost:8001'),
    ],

    'banking' => [
        'url' => env('BANKING_SERVICE_URL', 'http://localhost:8002'),
    ],

    'payment' => [
        'url' => env('PAYMENT_SERVICE_URL', 'http://localhost:8003'),
    ],

    'internal_secret' => env('INTERNAL_SECRET_KEY', 'cimb_internal_secret_2026'),

];

