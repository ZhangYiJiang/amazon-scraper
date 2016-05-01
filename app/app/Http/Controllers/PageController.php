<?php

namespace App\Http\Controllers;

use App\Book;
use App\Keyword;
use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{
    public function index()
    {
        $keywords = Keyword::all();
        $books = Book::take(30)->get();

        return view('pages.home', compact('keywords', 'books'));
    }

    public function keyword(Keyword $keyword)
    {
        return view('pages.keyword', compact('keyword'));
    }
}
