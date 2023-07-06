<?php
//use function Tamtamchik\SimpleFlash\flash;
$this->layout('template', ['title' => 'About page']);
echo flash()->display('error');
?>

<h1><?= $this->e($name) ?></h1>