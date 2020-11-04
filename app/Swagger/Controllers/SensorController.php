<?php

/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 5/9/19
 * Time: 10:39 AM
 */

namespace App\Swagger\Controllers;

class SensorController
{
    /**
     * 
     * @SWG\Get(
     *   path="/sensors",
     *   summary="Sensors",
     *   tags={"Sensors"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     * 
     * @SWG\Get(
     *   path="/sensors/{id}",
     *   summary="Get Sensors",
     *   tags={"Sensors"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       type="number"
     *   ),
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     * 
     * @SWG\Post(
     *   path="/sensors",
     *   summary="Store Sensors",
     *   tags={"Sensors"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Parameter(
     *       name="name",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     * 
     * @SWG\Put(
     *   path="/sensors/{id}",
     *   summary="Update Sensors",
     *   tags={"Sensors"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       type="number"
     *   ),
     *   @SWG\Parameter(
     *       name="name",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     * 
     * @SWG\Delete(
     *   path="/sensors/{id}",
     *   summary="Delete Sensors",
     *   tags={"Sensors"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Parameter(
     *       name="id",
     *       in="path",
     *       required=true,
     *       type="number"
     *   ),
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     */
}
