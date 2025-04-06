<?php

namespace BadMushroom\Shorties;

use BadMushroom\Shorties\Jobs\TrackLinkUsage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ShortiesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            // -- Configuration Files

            $this->publishes([
                __DIR__ . '/../config/shorties.php' => config_path('shorties.php'),
            ], 'shorties-config');

            // -- View Files

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/shorties'),
            ], 'shorties-views');

            // -- Artisan Commands

            $this->commands([
                \BadMushroom\Shorties\Console\Commands\ShortiesLinksAdmin::class,
                \BadMushroom\Shorties\Console\Commands\ShortiesLinksCreate::class,
            ]);

            // -- Migrations

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'shorties');
        $this->registerRoutes();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/shorties.php', 'shorties');

        $this->app->bind('shorties', function ($app) {
            return new Shorties(
                $app['config']->get('shorties.short_url_length'),
                $app['config']->get('shorties.short_url_prefix'),
                $app['config']->get('shorties.cache_ttl_minutes')
            );
        });
    }

    protected function registerRoutes(): void
    {
        $mode = Config::get('shorties.route_mode');
        $middleware = Config::get('shorties.middleware');
        $prefix = Config::get('shorties.prefix');
        $subdomain = Config::get('shorties.subdomain');
        $router = Route::middleware($middleware);

        if ($mode === 'subdomain' && $subdomain) {
            $router->domain("{$subdomain}." . parse_url(Config::get('app.url'), PHP_URL_HOST));
        } elseif ($mode === 'path') {
            $router->prefix($prefix);
        }

        $router->group(function () {
            Route::get('/{shortCode}', function ($shortCode) {
                $shorties = app('shorties');

                $url = $shorties->lookup($shortCode);

                if (!$url) {
                    return response()->view('shorties::not-found', [], 404);
                }

                if (Config::get('shorties.track_analytics', false)) {
                    TrackLinkUsage::dispatch($url->id, [
                        'user_agent' => request()->userAgent(),
                        'visit_date' => now(),
                    ]);
                }

                return redirect()->to($url->long_url);
            });
        });
    }
}
