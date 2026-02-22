<?php

use Illuminate\Support\Str;

return [
    'test_amount_vnd' => env('TEST_AMOUNT_VND', 1200),
    'default_fare_vnd' => env('DEFAULT_FARE_VND', 1200),
    'allowed_amount_delta' => (int) env('ALLOWED_AMOUNT_DELTA', 0),
    'default_provider' => env('PAYMENT_QR_PROVIDER', 'vietqr'),
    'display_min_vnd' => (int) env('TRIP_PRICE_MIN_VND', 1000),
    'display_max_vnd' => (int) env('TRIP_PRICE_MAX_VND', 2000),
    'ticket_hold_minutes' => (int) env('TICKET_HOLD_MINUTES', 10),
    'providers' => [
        'vietqr' => [
            'label' => 'VietQR',
            'account' => env('VIETQR_ACCOUNT', 'VCB-1037240068'),
        ],
        'momo' => [
            'label' => 'MoMo',
            'account' => env('VIETQR_ACCOUNT', 'VCB-1037240068'),
        ],
        'zalopay' => [
            'label' => 'ZaloPay',
            'account' => env('ZALOPAY_ACCOUNT', 'ZP-1234567890'),
        ],
    ],
    'intent_expiration_minutes' => env('PAYMENT_INTENT_EXP_MIN', 15),
    'webhook_secret' => env('WEBHOOK_SECRET', Str::random(32)),
];
