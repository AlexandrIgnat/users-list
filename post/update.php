<?php
include $_SERVER['DOCUMENT_ROOT'] . '/func.php';
$db = include $_SERVER['DOCUMENT_ROOT'] . '/database/core.php';

$db->update('posts', $_POST, $_GET['id']);
// $post = $db->getOne('posts', $_GET['id']);