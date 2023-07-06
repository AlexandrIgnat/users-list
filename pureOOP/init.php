<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/Config.php';
require_once 'classes/Input.php';
require_once 'classes/Validation.php';
require_once 'classes/Token.php';
require_once 'classes/Session.php';
require_once 'classes/User.php';
require_once 'classes/Redirect.php';
require_once 'classes/Cookie.php';

if (Cookie::exists(Config::get('cookie.name')) && !Session::exists(Config::get('session.user_session'))) {
    $hash = Cookie::get(Config::get('cookie.name'));
    $hashCheck = Database::getInstance()->get('user_hash', ['hash', '=', $hash]);

    if ($hashCheck->getCount()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}