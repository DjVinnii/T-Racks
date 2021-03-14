<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RackUnit extends Model
{
    use HasFactory;

    protected $table = 'rack_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rack_id',
        'unit_no',
        'hardware_id',
        'position', // 1 = front, 2 = interior, 3 = back

//        'front',
//        'interior',
//        'back',
    ];

    public function Rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function Hardware()
    {
        return $this->belongsTo(Hardware::class);
    }
}
