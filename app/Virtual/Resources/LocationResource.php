<?php

namespace App\Virtual\Resources;

/**
* @OA\Schema(
*     title="Location Resource",
*     description="Location resource",
*     @OA\Xml(
*         name="Location Resource"
*     )
* )
*/
class LocationResource
{
/**
* @OA\Property(
*     title="Data",
*     description="Data wrapper"
* )
*
* @var \App\Virtual\Models\Location[]
*/
private $data;
}
