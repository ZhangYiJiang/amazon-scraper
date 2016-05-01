<?php

namespace App\Http\Controllers\Api;

class BookController extends ApiController
{
    protected $excluded = 'books';

    protected $included = ['authors'];
    
    protected $related = ['authors', 'keywords'];

    protected function getModel()
    {
        return \App\Book::class;
    }
}
