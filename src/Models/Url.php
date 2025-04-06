<?php

namespace BadMushroom\Shorties\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'shorties_urls';

    protected $fillable = [
        'long_url',
        'short_code',
    ];

    protected $with = [
        'analytics',
    ];

    // -- Relationships

    public function analytics()
    {
        return $this->hasMany(Analytic::class, 'shorties_url_id');
    }

    // -- Accessors

    /**
     * Get the visits attribute.
     *
     * We could consider adding this to the $counts array, but if we
     * decide to filter the analytics or limit the number of results
     * by some constraint, this gives us a place to do it.
     */
    public function getVisitsAttribute(): int
    {
        return $this->analytics->count();
    }
}
