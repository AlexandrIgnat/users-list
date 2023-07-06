<?php
include $_SERVER['DOCUMENT_ROOT'] . '/func.php';
$db = include $_SERVER['DOCUMENT_ROOT'] . '/database/core.php';

$post = $db->getOne('posts', $_GET['id']);

include $_SERVER['DOCUMENT_ROOT'] . '/view/post/edit.php';