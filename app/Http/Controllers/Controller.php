<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @SWG\Swagger(
 *     basePath="",
 *     schemes={"http", "https"},
 *     host=L5_SWAGGER_CONST_HOST,
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="ProActive Swagger",
 *         description="ProActive Swagger API description",
 *         @SWG\Contact(
 *             email="your-email@domain.com"
 *         ),
 *     )
 * )
 */


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



}
