<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Update Rack Request",
 *      description="Update Rack request body data",
 *      type="object",
 *      required={"name"},
 *      required={"height"},
 *      required={"row_id"}
 * )
 */

class UpdateRackRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="New name of the Rack",
     *      example="Rack 1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="height",
     *      description="Height of the Rack",
     *      example="48"
     * )
     *
     * @var integer
     */
    public $height;


    /**
     * @OA\Property(
     *      title="row_id",
     *      description="New row_id of the Rack",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $row_id;
}
