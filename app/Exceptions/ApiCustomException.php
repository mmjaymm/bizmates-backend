<?php

namespace App\Exceptions;

use Exception;

class ApiCustomException extends Exception
{
    protected $data;

    public function __construct($message = "", $data = [], $code = 0, Exception $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function getData()
    {
        return $this->data;
    }
}
