<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="404",
 *     description="404 model",
 *     @OA\Xml(
 *         name="404"
 *     )
 * )
 */
class Error404
{
    /**
     * @OA\Property(
     *      title="Message",
     *      description="The error message",
     *      example="Not Found!"
     * )
     *
     * @var string
     */
    public $message;
}
