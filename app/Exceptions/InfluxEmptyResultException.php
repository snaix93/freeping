<?php

namespace App\Exceptions;

use Exception;

class InfluxEmptyResultException extends Exception
{
    protected $message = "No records found.";
}
