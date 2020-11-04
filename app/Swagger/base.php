<?php
/**
 * @SWG\Swagger(
 *      schemes={"http", "https"},
 *      host=L5_SWAGGER_CONST_HOST,
 *      basePath=L5_SWAGGER_CONST_BASE_PATH,
 *      @SWG\Info(
 *          version="1.0.0",
 *          title="Libelium Project API",
 *          description="Libelium Project API description",
 *          @SWG\Contact(
 *              email="16520950@gm.uit.edu.vn"
 *          ),
 *      ),
 *     @SWG\Tag(
 *          name="Authentication",
 *          description="Authentication description"
 *      ),
 *     @SWG\Tag(
 *          name="Devices",
 *          description="Devices description"
 *      )
 *  )
 */

# ============ Security =================
/**
 * @SWG\SecurityScheme(
 *     securityDefinition="APIKeyHeader",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 * )
 */
