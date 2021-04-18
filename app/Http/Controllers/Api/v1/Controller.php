<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="T-Racks OpenApi Documentation",
     *      description="T-Racks Swagger OpenApi description",
     *      @OA\Contact(
     *          email="vincent@vinniict.nl"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="T-Racks Server"
     * )
     *
     * @OA\Tag(
     *     name="Locations",
     *     description="API Endpoints of Locations"
     * )
     *
     * @OA\Tag(
     *     name="Rows",
     *     description="API Endpoints of Rows"
     * )
     */
}
