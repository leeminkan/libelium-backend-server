<?php
/**
 * Created by PhpStorm
 * User: khanh
 * Date: 7/30/19
 * Time: 12:02 PM
 */

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected $validator;

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param $validator
     * @return $this
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }
}
