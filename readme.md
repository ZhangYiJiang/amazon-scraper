# Amazon Web Scraper

A simple toy project that scrapes Amazon search results and displays the data on a
simple webpage. This was created as part of the job application for Glints. 

Demo available - https://meebleforp.com/projects/glints/

# IF YOU ARE APPLYING FOR A JOB WITH GLINTS, I WOULD STRONGLY RECOMMEND YOU STOP NOW

More: https://www.facebook.com/zhangyijiang/posts/10154341187913216

## Stack:

 - Laravel 5.2 PHP framework
 - Python 3.5 with requests and Beautiful Soup 4.4 for scraping
 - Bootstrap 3 with a touch of jQuery

## Prerequisites

 - PHP 7 (5.6 should work as well but is not tested)
 - Python 3.5, preferably set up in a virtualenv

## Setup

 1. Clone the repo
 2. In the `app` folder:
    1. Run `composer install` to install all prerequisites
    2. Copy the `.env.example` to `.env` and edit the following configurations
     - Database configuration
     - Site location
     - App secret (use `php artisan key:generate`)
    3. Run database migrations - `php artisan migrate --seed`
 3. In the `scraper` folder:
    1. (Optional) Setup pyvenv `pyvenv scraper/pyvenv` and activate it `source pyvenv/bin/activate`
    2. Install prerequisites for scraper - `pip install requests beautifulsoup4`
 4. In the `app` folder, run `php artisan scrape:keyword` to start scraping books under each topic
 5. After that run `php artisan scrape:author` to collect author bio
 6. To test the site locally, run `php artisan serve`
 7. (Optional) To rerun the scrape job on a regular basis, add a cron job either directly
 to the `scrape:keyword` command or to `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`
  then add the command to `App\Console\Kernel` as per https://laravel.com/docs/5.2/scheduling

## API

The API can be found under `/api/vi`. Documentation will be finished shortly, but for now try these

 - `/api/v1/books` - lists of all books
 - `/api/v1/books/1;2;3?fields=description` - books ID 1, 2 and 3 with their description
 - `/api/v1/books?pagesize=10&fields=authors.bio;authors.url;isbn` - the first 10 books
 with their author's bio, URL and ISBN, when available
 - `/api/v1/keywords` - list of all topics
 - `/api/v1/authors` - list of all authors

## Todo

This was done in a very short period of time, so there's a large number of things left
to be done

 - API documentation
 - Topics listings page
 - Touching up UI
 - Cleaning up API code
 - Make scrapes more accurate and reliable
