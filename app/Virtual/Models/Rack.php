<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Rack",
 *     description="Rack model",
 *     @OA\Xml(
 *         name="Rack"
 *     )
 * )
 */
class Rack
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="The name of the Rack",
     *      example="Rack 1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Height",
     *     description="The height of the Rack",
     *     format="int64",
     *     example=48
     * )
     *
     * @var integer
     */
    public $height;

    /**
     * @OA\Property(
     *     title="Row ID",
     *     description="The ID of the Row",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $location_id;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private $updated_at;
}
