<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    'facebook' => [
        'client_id' => env('facebook_client_id'),
        'client_secret' => env('facebook_client_secret'),
        'redirect' => env('facebook_redirect'),
    ],
    
    'linkedin' => [
        'client_id' => env('linkedin_client_id'),
        'client_secret' => env('linkedin_client_secret'),
        'redirect' => env('linkedin_redirect'),
    ],
    
    'google' => [
        'client_id' => env('google_client_id'),
        'client_secret' => env('google_client_secret'),
        'redirect' => env('google_redirect'),
    ],
];
