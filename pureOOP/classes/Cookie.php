<?php

class Cookie
{
    public static function put($name, $value, $life_time)
    {
        if (setcookie($name, $value, time() + $life_time, '/')) {
            return true;
        }

        return false;
    }

    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    public static function exists($name)
    {
        if (isset($_COOKIE[$name])) {
            return true;
        }

        return false;
    }

    public static function delete($name)
    {
        self::put($name, '', time() -1);
    }
}