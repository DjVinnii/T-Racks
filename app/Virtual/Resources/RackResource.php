<?php

namespace App\Virtual\Resources;

/**
* @OA\Schema(
*     title="Rack Resource",
*     description="Rack resource",
*     @OA\Xml(
*         name="Rack Resource"
*     )
* )
*/
class RackResource
{
/**
* @OA\Property(
*     title="Data",
*     description="Data wrapper"
* )
*
* @var \App\Virtual\Models\Rack[]
*/
private $data;
}
