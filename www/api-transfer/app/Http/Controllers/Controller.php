<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\OpenApi(
     *   @OA\Server(
     *      url="/api/v1"
     *   ),
     *   @OA\Info(
     *      title="Swagger-Demo",
     *      version="1.0.0",
     *   ),
     * )
     */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
