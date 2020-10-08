<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public static function modelNotFound()
    {
        return new static("model_not_found", 1000);
    }
}
