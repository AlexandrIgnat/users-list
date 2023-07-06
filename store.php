<?php

include 'func.php';
$db = include 'database/core.php';

$db->create('posts', [
    'title' => $_POST['title'],
    'preview' => $_POST['preview'],
    'description' => $_POST['description'],
    'thumbnail' => $_POST['thumbnail'],
]);