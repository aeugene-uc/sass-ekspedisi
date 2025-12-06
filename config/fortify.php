<?php

use Laravel\Fortify\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Fortify Guard
    |--------------------------------------------------------------------------
    |
    | Here you may specify the authentication guard Fortify will use while
    | authenticating users. Usually this is "web".
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Fortify Password Broker
    |--------------------------------------------------------------------------
    */

    'passwords' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | This is the field that the user uses to log in. Default = email.
    |
    */

    'username' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Home Path
    |--------------------------------------------------------------------------
    |
    | Where users are redirected after login or registration.
    |
    */

    'home' => '/dashboard',

    /*
    |--------------------------------------------------------------------------
    | Redirects
    |--------------------------------------------------------------------------
    |
    | Optional: customize redirect paths.
    |
    */

    'redirects' => [
        'login' => null,
        'logout' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Views (You Decide)
    |--------------------------------------------------------------------------
    |
    | Fortify uses callbacks (defined in FortifyServiceProvider) to show views.
    | Do not put view references here.
    |
    */

    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Enable only what you need.
    |
    | You only want:
    | - Registration
    | - Login (always enabled)
    | - Password reset
    |
    | NO email verification, NO 2FA, NO everything else.
    |
    */

    'features' => [
        Features::registration(),
        Features::resetPasswords(),

        // Disabled features:
        // Features::emailVerification(),
        // Features::updateProfileInformation(),
        // Features::updatePasswords(),
        // Features::twoFactorAuthentication(),
    ],
];
