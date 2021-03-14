<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $table = 'ports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hardware_id',
        'name',
        'mac_address',
    ];

    public function hardware()
    {
        return $this->belongsTo(Hardware::class);
    }
}
