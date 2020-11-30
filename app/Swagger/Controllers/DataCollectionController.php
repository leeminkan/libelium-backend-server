<?php

/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 5/9/19
 * Time: 10:39 AM
 */

namespace App\Swagger\Controllers;

class DataCollectionController
{
    /**
     * 
     * @SWG\Post(
     *   path="/data-collections/seed",
     *   summary="Seed data collection",
     *   tags={"Data Collection"},
     *   security={
     *       {"APIKeyHeader": {}}
     *   },
     *   @SWG\Parameter(
     *       name="body",
     *       in="body",
     *       required=true,
     *       @SWG\Schema(
     *          required={"data"},
     *          @SWG\Property(
     *              property="data",
     *              type="array",
     *              @SWG\Items(
     *                  type="string",
     *                  example="{'waspmote_id': 'waspmote_id', 'sensor_key': 'temperature', 'value': '30'}"
     *                 )
     *          )
     *      )
     *   ),
     *   @SWG\Response(response=200, description="Successful operation"),
     *   @SWG\Response(response=422, description="Unprocessable Entity"),
     *   @SWG\Response(response=500, description="Internal server error")
     * )
     */
}
