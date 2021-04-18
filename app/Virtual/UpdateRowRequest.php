<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update Row Request",
 *      description="Update Row request body data",
 *      type="object",
 *      required={"name"},
 *      required={"location_id"}
 * )
 */

class UpdateRowRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="New name of the row",
     *      example="Row 1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="location_id",
     *      description="New location_id of the row",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $location_id;
}
