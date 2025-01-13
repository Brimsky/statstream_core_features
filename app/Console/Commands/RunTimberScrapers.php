<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Scrapers\TimberScraper;

class RunTimberScrapers extends Command
{
    protected $signature = 'timber:scrape';
    protected $description = 'Run all timber scrapers to update prices';

    public function handle()
    {
        $this->info('Starting timber scrapers...');
        
        // Add your scraper logic here
        // Example:
        // $scraper = new TimberScraper();
        // $scraper->run();
        
        $this->info('Timber scrapers completed successfully.');
    }
}
