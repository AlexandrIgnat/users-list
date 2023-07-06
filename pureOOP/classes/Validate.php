<?php

class Validate
{
    private $passed = false, $errors = [], $db = null;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function check($method, $data)
    {

    }

    public function passed()
    {

    }
}