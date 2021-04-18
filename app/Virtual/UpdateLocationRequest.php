<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update Location Request",
 *      description="Update Locations request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class UpdateLocationRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="New name of the location",
     *      example="Location 1"
     * )
     *
     * @var string
     */
    public $name;
}
