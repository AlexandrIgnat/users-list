<?php

$GLOBALS['config'] = [
    'mysql' => [
        'connection' => 'mysql:host=127.0.0.1',
        'host'     => 'localhost',
        'database' => 'laravel',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],

    'session' => [
        'token_name' => 'token',
        'user_session' => 'user',
    ],
    'cookie' => [
        'name' => 'hash',
        'life_time' => 604800,
    ]
];

class Config
{
    public static function get($path = null)
    {
        if ($path) {
            $config = $GLOBALS['config'];

            $path = explode('.', $path);

            foreach ($path as $item) {
                if (isset($config[$item])) {
                    $config = $config[$item];
                }
            }

            return $config;
        }

        return false;
    }
}
