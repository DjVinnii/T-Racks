<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read string $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property-read Rack|null $rack
 */
class Device extends Model
{
    use HasUuids, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class);
    }
}
