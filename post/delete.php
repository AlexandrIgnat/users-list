<?php
include $_SERVER['DOCUMENT_ROOT'] . '/func.php';
$db = include $_SERVER['DOCUMENT_ROOT'] . '/database/core.php';

$db->delete("posts", $_GET['id']);