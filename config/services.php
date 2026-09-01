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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'meta' => [
        'pixel_id' => env('META_PIXEL_ID'),
    ],
    
    'shipping' => [
        'base_rate'         => env('SHIPPING_BASE_RATE', 50.00),
        'free_shipping_above' => env('SHIPPING_FREE_ABOVE', 500.00),
    ],
    'facebook' => [
        'feed_limit' => env('UBR_FEED_PRODUCT_LIMIT', 1000),
        'sale_days' => env('UBR_SALE_PRICE_WINDOW_DAYS', 90),
    ],
];