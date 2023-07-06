<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if( !session_id() ) {
    session_start();
}

require_once "./../vendor/autoload.php";
use function \Tamtamchik\SimpleFlash\flash;
new App\controllers\Router();

//if ($_SERVER['REQUEST_URI'] === '/home') {
//    require_once '../app/controllers/HomeController.php';
//}
