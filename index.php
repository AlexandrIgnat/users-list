<?php
include 'func.php';
$db = include 'database/core.php';

 $post = $db->getOne('posts', 5);
dd($_SERVER);
$posts = $db->getAll('posts');

include 'index.view.php';