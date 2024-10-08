<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;


class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the website';

    /**
     * Execute the console command.
     */

     public function handle()
     {
         // Define the path where the sitemap will be saved
         $sitemapPath = public_path('sitemap.xml');
 
         // Generate the sitemap with exclusions and save it to the specified path
         SitemapGenerator::create(config('app.url'))
             ->hasCrawled(function (Url $url) {
                 // Exclude URLs containing 'admin'
                 if ($url->segment(1) === 'admin') {
                     return;
                 }
 
                 return $url;
             })
             ->writeToFile($sitemapPath);
 
         // Output a success message
         $this->info('Sitemap generated successfully.');
     }


    }