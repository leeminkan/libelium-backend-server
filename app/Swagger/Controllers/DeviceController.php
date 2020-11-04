<?php

/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 5/9/19
 * Time: 10:39 AM
 */

namespace App\Swagger\Controllers;

class DeviceController
{
    /**
     * 
     * @SWG\Get(
     *   path="/devices",
     *   summary="Devices",
     *   tags={"Devices"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     * 
     * @SWG\Get(
     *   path="/devices/{id}",
     *   summary="Get Devices",
     *   tags={"Devices"},
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
     *   path="/devices",
     *   summary="Store Devices",
     *   tags={"Devices"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Parameter(
     *       name="waspmote_id",
     *       in="formData",
     *       required=true,
     *       type="string"
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
     * @SWG\Put(
     *   path="/devices/{id}",
     *   summary="Update Devices",
     *   tags={"Devices"},
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
     *       name="waspmote_id",
     *       in="formData",
     *       required=true,
     *       type="string"
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
     *   path="/devices/{id}",
     *   summary="Delete Devices",
     *   tags={"Devices"},
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
