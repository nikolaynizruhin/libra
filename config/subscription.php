<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stripe Product
    |--------------------------------------------------------------------------
    |
    | Stripe product id associated with subscription plans.
    |
    */

    'product' => env('STRIPE_PRODUCT'),

    /*
    |--------------------------------------------------------------------------
    | Plans
    |--------------------------------------------------------------------------
    |
    | Available subscription plans.
    |
    */

    'plans' => [
        [
            'nickname' => 'Basic',
            'amount' => 1000,
            'interval' => 'month',
        ],
        [
            'nickname' => 'Premium',
            'amount' => 2000,
            'interval' => 'month',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Trial Period
    |--------------------------------------------------------------------------
    |
    | The number of days of the trial period.
    |
    */

    'trial_days' => 7,

    /*
    |--------------------------------------------------------------------------
    | Currency Symbol
    |--------------------------------------------------------------------------
    |
    | Provides symbol for a given currency.
    |
    */

    'currency_symbols' => [
        'usd' => '$',
        'eur' => '€',
    ],

];
