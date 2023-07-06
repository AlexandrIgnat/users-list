<?php

class Validation
{
    private $passed = false, $errors = [], $db = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function check($method, $fields = [])
    {
        foreach ($fields as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                $value = $method[$item];

                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'matched':
                            if ($value != $method[$rule_value]) {
                                $this->addError("{$item} must be a matched {$rule_value}");
                            }
                            break;
                        case 'unique':
                            $check = $this->db->get($rule_value, [$item, '=', $value]);
                            if ($check->getCount()) {
                                $this->addError("{$item} must be a unique");
                            }
                            break;
                        case 'email':
                            if ($rule_value) {
                                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    $this->addError("{$item} must be valid");
                                }
                            }
                    }
                }
            }
        }

        if (empty($this->getErrors())) {
            $this->passed = true;
        }

        return $this;
    }

    public function passed()
    {
        return $this->passed;
    }

    public function addError($errorMessage)
    {
        $this->errors[] = $errorMessage;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}