<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '850231716032-r84fktuhsb6scc2c1lg57sho1c08eo94.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => env('APP_URL').'auth/google/callback',
    ],
    'facebook' => [
        'client_id' => '225161839945062',
        'client_secret' => '2be7295ab22d674b0e4eda1fa84cd546',
        'redirect' => env('APP_URL').'auth/facebook/callback',
    ],
];
