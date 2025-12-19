<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
    ];

    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class);
    }
}
