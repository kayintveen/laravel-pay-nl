<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pay.nl API Token Code
    |--------------------------------------------------------------------------
    |
    | Your Pay.nl API token code for authentication.
    | You can find this in your Pay.nl dashboard under Settings > API tokens.
    |
    */

    'token_code' => env('PAYNL_TOKEN_CODE'),

    /*
    |--------------------------------------------------------------------------
    | Pay.nl API Token
    |--------------------------------------------------------------------------
    |
    | Your Pay.nl API token for authentication.
    | You can find this in your Pay.nl dashboard under Settings > API tokens.
    |
    */

    'api_token' => env('PAYNL_API_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Pay.nl Service ID
    |--------------------------------------------------------------------------
    |
    | Your Pay.nl service ID. This identifies which service/website
    | the payment belongs to.
    |
    */

    'service_id' => env('PAYNL_SERVICE_ID'),

    /*
    |--------------------------------------------------------------------------
    | Test Mode
    |--------------------------------------------------------------------------
    |
    | Set to true to enable test mode. In test mode, no real transactions
    | will be processed.
    |
    */

    'test_mode' => env('PAYNL_TESTMODE', false),

];
