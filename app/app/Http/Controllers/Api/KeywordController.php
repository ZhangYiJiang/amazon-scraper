<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

class KeywordController extends ApiController
{
    protected $excluded = 'keywords';

    protected $related = ['books'];

    protected function getModel()
    {
        return \App\Keyword::class;
    }
}
