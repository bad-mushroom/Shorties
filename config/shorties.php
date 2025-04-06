<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Short URL Code Length
    |--------------------------------------------------------------------------
    |
    | This value determines how many characters will be used in the generated
    | short code for a shortened URL. You may adjust this based on the
    | desired level of uniqueness and readability.
    |
    | The default is 6 characters, which allows for 56,800 unique codes. The
    | maximum is 20 characters, which allows for 3,486,784,401 unique codes.
    |
    */

    'short_url_length' => env('SHORT_URL_CODE_LENGTH', 6),

    /*
    |--------------------------------------------------------------------------
    | Route Mode
    |--------------------------------------------------------------------------
    |
    | Choose how the short URLs should be served.
    | - 'subdomain': will respond to a dedicated subdomain like go.example.com
    | - 'path': will use a prefix on the main domain like example.com/shorties
    |
    */

    'route_mode' => env('SHORTIES_ROUTE_MODE', 'path'), // or 'subdomain'

    /*
    |--------------------------------------------------------------------------
    | Short URL Prefix
    |--------------------------------------------------------------------------
    |
    | This value is used to build the full short URL when returning or displaying
    | it. It should include the scheme and domain (e.g. https://go.example.com).
    |
    */

    'short_url_prefix' => env('SHORT_URL_PREFIX', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Subdomain (used only if route_mode is 'subdomain')
    |--------------------------------------------------------------------------
    |
    | Specify the subdomain to handle short URLs (e.g. "go").
    | Leave null to ignore subdomain binding.
    |
    */

    'subdomain' => env('SHORTIES_SUBDOMAIN', 'go'),

    /*
    |--------------------------------------------------------------------------
    | Prefix (used only if route_mode is 'path')
    |--------------------------------------------------------------------------
    |
    | The URI path prefix to use when route_mode is 'path'
    |
    */

    'prefix' => env('SHORTIES_PATH', 'shorties'),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL (Minutes)
    |--------------------------------------------------------------------------
    |
    | The number of minutes to cache resolved short URLs. This helps reduce
    | database lookups for frequently accessed short links.
    |
    */

    'cache_ttl_minutes' => env('SHORT_URL_CACHE_TTL', 60),

    /*
    |--------------------------------------------------------------------------
    | Analytics Tracking
    |--------------------------------------------------------------------------
    |
    | Enable or disable automatic analytics tracking when a short URL is accessed.
    | If enabled, a tracking job will be dispatched for every resolved visit.
    |
    */

    'track_analytics' => env('SHORTIES_TRACK_ANALYTICS', true),

    /*
    |--------------------------------------------------------------------------
    | Analytics Retention Days
    |--------------------------------------------------------------------------
    |
    | Define how many days to keep analytics records. Older entries will be
    | pruned automatically when the Laravel model:prune command is run.
    |
    */

    'analytics_retention_days' => env('SHORTIES_ANALYTICS_RETENTION_DAYS', 90),

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    */

    'middleware' => [],

];
