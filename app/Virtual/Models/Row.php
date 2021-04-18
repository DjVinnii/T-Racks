<?php

namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Row",
 *     description="Row model",
 *     @OA\Xml(
 *         name="Row"
 *     )
 * )
 */
class Row
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
     *      description="The name of the row",
     *      example="Row 1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Location ID",
     *     description="The ID of the location",
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
