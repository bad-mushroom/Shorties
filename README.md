![shorties_logo_transparent_512x512](https://github.com/user-attachments/assets/1d1b3191-df78-4f2a-81d0-18332884090b)

# Shorties

A Laravel package for generating, managing, and tracking short URLs — complete with analytics, customizable routing, view overrides, and pruning.

---

## 🚀 Features

- Generate short URLs with custom or random codes
- Subdomain or path-based routing (configurable)
- Visitor analytics tracking (with fingerprinting, user agent, etc.)
- Optional view override for 404-style "link not found" page
- Artisan commands for creating and listing short links
- Configurable data retention with built-in Laravel pruning support

---

## 📦 Installation

```bash
composer require badmushroom/shorties
```

Publish config and views (optional):

```bash
php artisan vendor:publish --tag=shorties-config
php artisan vendor:publish --tag=shorties-views
```

Run migrations:

```bash
php artisan migrate
```

---

## ⚙️ Configuration

In `config/shorties.php`, you can configure:

| Key                        | Description                                                                 |
|---------------------------|-----------------------------------------------------------------------------|
| `route_mode`              | `subdomain` or `path`                                                       |
| `subdomain`               | Subdomain to use for short links (e.g. `go`)                                |
| `prefix`                  | URI prefix to use if using `path` mode (e.g. `shorties`)                    |
| `middleware`              | Middleware group applied to short URL routes (`web`, `api`, etc.)           |
| `track_analytics`         | Enable or disable tracking of short URL visits                              |
| `analytics_retention_days`| Number of days to keep analytics records before pruning                     |

### Example `.env` settings

```env
SHORTIES_ROUTE_MODE=path
SHORTIES_PATH=shorties
SHORTIES_TRACK_ANALYTICS=true
SHORTIES_ANALYTICS_RETENTION_DAYS=90
```

---

## 🌐 Routing

Shorties can handle links either by subdomain or by path:

### Subdomain-based:

```
https://go.example.com/my-short-code
```

Set in config:

```php
'route_mode' => 'subdomain',
'subdomain' => 'go',
```

### Path-based:

```
https://example.com/shorties/my-short-code
```

Set in config:

```php
'route_mode' => 'path',
'prefix' => 'shorties',
```

---

## 📊 Analytics Tracking

When `track_analytics` is enabled, Shorties will dispatch a job on each short link visit that records:

- UUID of the URL
- Timestamp (`visited_at`)
- User agent
- Fingerprint (if provided)

Records are stored in `shorties_analytics`.

---

## 🧼 Pruning Old Analytics

Shorties supports Laravel's [Model Pruning](https://laravel.com/docs/master/eloquent#pruning-models) to automatically remove old analytics data.

Add this to your scheduler:

```php
$schedule->command('model:prune')->daily();
```

Configure retention via:

```env
SHORTIES_ANALYTICS_RETENTION_DAYS=90
```

Or update `config/shorties.php`.

You can prune manually with:

```bash
php artisan model:prune --model="BadMushroom\Shorties\Models\Analytic"
```

---

## 🛠 Artisan Commands

### Create a new short link:

```bash
php artisan shorties:links:create
```

Interactively prompts for a long URL and optional short code.

### Admin listing of short links:

```bash
php artisan shorties:links
```

Displays a table of existing short codes, their URLs, visit counts, and creation timestamps.

---

## 🎨 Customizing the 404 View

To show a custom “link not found” page, publish the default view:

```bash
php artisan vendor:publish --tag=shorties-views
```

Edit the published file at:

```
resources/views/vendor/shorties/not-found.blade.php
```

---

## 🔒 Security & Notes

- Uses UUIDs for both URL and analytic IDs
- Tracks analytics only if enabled via config
- Prunes old records based on configurable retention
- Routes are scoped to either a path or subdomain

---

## 🧪 Testing

This package includes feature and unit tests. To run them:

```bash
vendor/bin/phpunit
```

---

## 🧾 License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

---

## 🤘 Made by [Bad Mushroom](https://github.com/badmushroom)
