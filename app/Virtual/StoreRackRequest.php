<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Rack Request",
 *      description="Store Rack request body data",
 *      type="object",
 *      required={"name"},
 *      required={"height"},
 *      required={"row_id"}
 * )
 */

class StoreRackRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new rack",
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
     *      description="ID of the Row",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $row_id;
}
