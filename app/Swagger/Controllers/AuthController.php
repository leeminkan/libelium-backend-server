<?php

/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 5/9/19
 * Time: 10:39 AM
 */

namespace App\Swagger\Controllers;

class AuthenticationController
{
    /**
     * @SWG\Post(
     *   path="/login",
     *   summary="Login",
     *   tags={"Authentication"},
     *   @SWG\Parameter(
     *       name="email",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Parameter(
     *       name="password",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     * 
     */
}
