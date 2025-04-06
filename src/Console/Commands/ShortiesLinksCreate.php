<?php

namespace BadMushroom\Shorties\Console\Commands;

use BadMushroom\Shorties\Facades\Shorty;
use Illuminate\Console\Command;

class ShortiesLinksCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shorties:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new short URL record.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        do {
            $longUrl = $this->ask('Enter the long URL (include HTTP/HTTPS:');

            if (empty($longUrl)) {
                $this->error('Long URL is required.');
            }
        } while (empty($longUrl));

        $shortCode = $this->ask('Enter the short code (leave blank to generate one)');

        $url = Shorty::create($longUrl, $shortCode);

        $this->info('Short URL created successfully!');
        $this->comment('Short Code: ' . $url->short_code);
        $this->comment('Long URL: ' . $url->long_url);
        $this->comment('Short Link: ' . $url->long_url . '/' . $url->short_code);

        return self::SUCCESS;
    }
}
