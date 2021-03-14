<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $table = 'hardware';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'hardware_type',
        'label',
        'asset_tag',

//        todo Hardware Model (Vendor, type etc)
    ];


    public function hardwareType()
    {
        return $this->belongsTo(HardwareType::class, 'hardware_type');
    }

    public function rackUnits()
    {
        return $this->hasMany(RackUnit::class);
    }

    public function ports()
    {
        return $this->hasMany(Port::class);
    }
}
