<?php
include $_SERVER['DOCUMENT_ROOT'] . '/database/QueryBuilder.php';
include $_SERVER['DOCUMENT_ROOT'] . '/database/Connection.php';
$config = include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

return new QueryBuilder(
    Connection::make($config['database'])
);