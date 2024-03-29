<?php

/*
 * This file is part of Laravel Optimus.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'user',

    /*
    |--------------------------------------------------------------------------
    | Optimus Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'user' => [
            'prime'   => env('OPTIMUS_PRIME_USER'),
            'inverse' => env('OPTIMUS_INVERSE_USER'),
            'random'  => env('OPTIMUS_RANDOM_USER'),
        ],

        'target' => [
            'prime'   => env('OPTIMUS_PRIME_TARGET'),
            'inverse' => env('OPTIMUS_INVERSE_TARGET'),
            'random'  => env('OPTIMUS_RANDOM_TARGET'),
        ],

        'web-check' => [
            'prime'   => env('OPTIMUS_PRIME_WEB_CHECK'),
            'inverse' => env('OPTIMUS_INVERSE_WEB_CHECK'),
            'random'  => env('OPTIMUS_RANDOM_WEB_CHECK'),
        ],

        'pulse' => [
            'prime'   => env('OPTIMUS_PRIME_PULSE'),
            'inverse' => env('OPTIMUS_INVERSE_PULSE'),
            'random'  => env('OPTIMUS_RANDOM_PULSE'),
        ],

        'ssl-check' => [
            'prime'   => env('OPTIMUS_PRIME_SSL_CHECK'),
            'inverse' => env('OPTIMUS_INVERSE_SSL_CHECK'),
            'random'  => env('OPTIMUS_RANDOM_SSL_CHECK'),
        ],

    ],

];
