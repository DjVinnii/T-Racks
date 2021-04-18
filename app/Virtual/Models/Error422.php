<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="422",
 *     description="422 model",
 *     @OA\Xml(
 *         name="422"
 *     )
 * )
 */
class Error422
{
    /**
     * @OA\Property(
     *      title="Message",
     *      description="The error message",
     *      example="The given data was invalid."
     * )
     *
     * @var string
     */
    public $message;
}
