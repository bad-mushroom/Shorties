<?php

namespace BadMushroom\Shorties\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Config;

class Analytic extends Model
{
    use HasFactory;
    use HasUuids;
    use Prunable;

    public $timestamps = false;

    protected $table = 'shorties_analytics';

    protected $fillable = [
        'shorties_url_id',
        'fingerprint',
        'visited_at',
    ];

    // -- Relationships

    public function url()
    {
        return $this->belongsTo(Url::class, 'shorties_url_id', 'id');
    }

    // -- Prunable Trait

    public function prunable()
    {
        $daysToRetain = Config::get('shorties.analytics_retention_days', 90);

        return static::where('visited_at', '<', now()->subDays($daysToRetain));
    }
}
