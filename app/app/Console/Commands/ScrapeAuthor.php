<?php

namespace App\Console\Commands;

use App\Author;
use Illuminate\Console\Command;

class ScrapeAuthor extends Command
{
    use ExecPython;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:author {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $authors = Author::whereNotNull('url')
            ->when( ! $this->option('refresh'), function($query){
                return $query->whereNull('bio');
            })->get();

        foreach ($authors as $author) {
            $results = $this->executePython('author_scraper.py', $author->url);

            $author->bio = $results['bio'];
            $author->save();
        }
    }
}
