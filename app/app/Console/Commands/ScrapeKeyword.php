<?php

namespace App\Console\Commands;

use App\Author;
use App\Book;
use App\Keyword;
use Illuminate\Console\Command;

class ScrapeKeyword extends Command
{
    use ExecPython;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:keyword {keyword?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
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
        if ($term = $this->argument('keyword')) {
            $keywords = Keyword::with('books')->where('term', $term)->get();
        } else {
            $keywords = Keyword::with('books')->get();
        }

        foreach ($keywords as $keyword) {
            $term = $keyword->term;
            $results = $this->executePython('keyword_scraper.py', $term);

            // TODO: Logging
            if (json_last_error())
                continue;
            
            $keyword->touch();

            foreach ($results as $result) {
                // Update book entry in the database
                $attributes = array_only($result,
                    ['description', 'title', 'rating', 'url', 'cover_url', 'isbn', 'asin']);

                $book = Book::updateOrCreate(array_only($result, 'asin'), $attributes);

                $book->keywords()->sync([$keyword->id], FALSE);

                // Update book prices in the database
                foreach ($result['price'] as $edition => $price) {
                    $book->prices()->updateOrCreate(compact('edition'), compact('price'));
                }

                // Update book author in the database
                $author = Author::updateOrCreate(
                    ['name' => $result['author_name']],
                    ['url' => $result['author_url']]
                );
                
                $book->authors()->sync([$author->id], FALSE);
            }
        }
    }
}
