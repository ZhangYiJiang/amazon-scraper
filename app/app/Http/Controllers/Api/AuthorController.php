<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;

class AuthorController extends ApiController
{
    protected $excluded = 'authors';
    
    protected $related = ['books'];

    protected function getModel()
    {
        return \App\Author::class;
    }
}
