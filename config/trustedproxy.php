<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Set trusted proxy IP addresses.
    |
    */

    'proxies' => env('TRUSTED_PROXIES', '*'), // Use '*' to trust all proxies or specify IP addresses

    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    |
    | Headers to check for proxy forwarding.
    |
    */

    'headers' => [
        Illuminate\Http\Request::HEADER_FORWARDED => 'FORWARDED',
        Illuminate\Http\Request::HEADER_X_FORWARDED_FOR => 'X_FORWARDED_FOR',
        Illuminate\Http\Request::HEADER_X_FORWARDED_HOST => 'X_FORWARDED_HOST',
        Illuminate\Http\Request::HEADER_X_FORWARDED_PORT => 'X_FORWARDED_PORT',
        Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO => 'X_FORWARDED_PROTO',
        Illuminate\Http\Request::HEADER_X_FORWARDED_PREFIX => 'X_FORWARDED_PREFIX',
        Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB => null,
    ],

];
