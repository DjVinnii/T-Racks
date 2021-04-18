<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Row Request",
 *      description="Store Row request body data",
 *      type="object",
 *      required={"name"},
 *      required={"location_id"}
 * )
 */

class StoreRowRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new row",
     *      example="Row 1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="location_id",
     *      description="ID of the Location",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $location_id;
}
