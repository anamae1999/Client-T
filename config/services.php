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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET_CARD'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'google' => [
        'key' => env('GOOGLE_KEY'),
        'server_key' => env('GOOGLE_SERVER_KEY'),
        'captcha_key' => env('GOOGLE_RECAPTCHA_KEY'),
        'captcha_secret' => env('GOOGLE_RECAPTCHA_SECRET'),
        'analytics_id' => env('GOOGLE_ANALYTICS_ID'),
    ],

    'email' => [
        'site_email' => env('MAIL_USERNAME'),
        'mail_receiver' => env('MAIL_RECEIVER'),
        'mail_screening' => env('MAIL_SCREENING'),
    ],

    'creditor' => [
        'name' => env('CREDITOR_NAME'),
        'identifier' => env('CREDITOR_IDENTIFIER'),
        'address' => env('CREDITOR_ADDRESS'),
    ],



];
