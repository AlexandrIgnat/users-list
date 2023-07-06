<?php 

function connectToDb() {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=laravel;charset=utf8;', 'root', '');
    
    return $pdo;
}

function dd($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}