<?php

namespace BadMushroom\Shorties\Console\Commands;

use Illuminate\Console\Command;
use BadMushroom\Shorties\Models\Url;
use Symfony\Component\Console\Helper\Table;

class ShortiesLinksAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shorties:links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display a table of URL records with their short codes.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records = Url::query()
            ->select([
                'id',
                'short_code',
                'long_url',
                'created_at',
                'updated_at',
            ])
            ->with('analytics')
            ->get();

        if ($records->isEmpty()) {
            $this->info('No Shorty records found.');

            return self::SUCCESS;
        }

        $table = new Table($this->output);
        $table->setHeaders(['Shorty', 'URL', 'Visits', 'Created At']);

        foreach ($records as $record) {
            $table->addRow([
                $record->short_code,
                $record->long_url,
                $record->visits,
                $record->created_at->toDateTimeString(),
            ]);
        }

        $table->render();

        return self::SUCCESS;
    }
}
