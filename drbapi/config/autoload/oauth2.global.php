<?php

return [
    'zf-oauth2' => [
        'allow_implicit' => false, // default (set to true when you need to support browser-based or mobile apps)
        'access_lifetime' => 3600, // default (set a value in seconds for access tokens lifetime)
        'enforce_state' => true,  // default
        'storage' => 'ZF\OAuth2\Doctrine\Adapter\DoctrineAdapter', // service name for the OAuth2 storage adapter
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=ta_ncp',
            'username' => 'dws',
            'password' => 'dws',
        ],
    ],
];
