<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Starter Kit Laravel Api Documentation",
 *      @OA\Contact(
 *          email="dkashavtsev@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Tag(
 *     name="Tokens",
 *     description="Auth Endpoints"
 * ),
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * ),
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Starter Kit Laravel API Server"
 * )
 */
class Controller extends \App\Http\Controllers\Controller
{
}
