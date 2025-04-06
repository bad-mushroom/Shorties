<?php

namespace BadMushroom\Shorties;

use BadMushroom\Shorties\Models\Url;

interface ShortiesInterface
{
    /**
     * Create a short URL record.
     */
    public function create(string $fullUrl): Url;

    /**
     * Retrieve a URL record by its short code.
     */
    public function lookup(string $shortCode): ?Url;

    /**
     * Generate a random short code.
     */
    public function makeShortCode(): string;

    /**
     * Check if a short code already exists.
     */
    public function doesShortCodeExist(string $shortCode): bool;
}
