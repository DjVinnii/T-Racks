<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Location Request",
 *      description="Store Locations request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StoreLocationRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new location",
     *      example="Location 1"
     * )
     *
     * @var string
     */
    public $name;
}
