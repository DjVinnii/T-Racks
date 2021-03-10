<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipv4Network extends Model
{
    use HasFactory;

    protected $table = 'ipv4_network';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network',
        'mask',
        'name',
    ];
}
