<?php

namespace App\Virtual\Resources;

/**
* @OA\Schema(
*     title="row Resource",
*     description="Row resource",
*     @OA\Xml(
*         name="Row Resource"
*     )
* )
*/
class RowResource
{
/**
* @OA\Property(
*     title="Data",
*     description="Data wrapper"
* )
*
* @var \App\Virtual\Models\Row[]
*/
private $data;
}
