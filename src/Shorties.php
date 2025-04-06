<?php

namespace BadMushroom\Shorties;

use BadMushroom\Shorties\Models\Url;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Shorties implements ShortiesInterface
{
    public function __construct(
        protected int $shortCodeLength,
        protected string $shortCodePrefix,
        protected int $ttlMinutes
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function create(string $fullUrl, ?string $predefinedShortCode = null): Url
    {
        do {
            $shortCode = $predefinedShortCode ?? $this->makeShortCode();
        } while ($this->doesShortCodeExist($shortCode));

        return Url::create([
            'long_url'   => $fullUrl,
            'short_code' => $shortCode,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function makeShortCode(): string
    {
        return Str::lower(Str::random($this->shortCodeLength));
    }

    /**
     * {@inheritDoc}
     */
    public function doesShortCodeExist(string $shortCode): bool
    {
        return Url::query()->where('short_code', $shortCode)->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function lookup(string $shortCode): ?Url
    {
        return Cache::remember($shortCode, $this->ttlMinutes, function () use ($shortCode) {
            return Url::query()
                ->where('short_code', $shortCode)
                ->first();
        });
    }
}
