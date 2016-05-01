<?php

namespace App\Providers;

use App\Keyword;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Constructs route-model binding that takes a list of semicolon separated
     * id's and returns an array of models that match the list
     *
     * @param string $class Name of the class to instantiate
     * @param string $column column to match the id's to
     * @return \Closure
     */
    protected function createBinding($class, $column = 'id')
    {
        return function($value) use ($class, $column)
        {
            $keys = array_slice(explode(';', $value), 0, config('api.pagesize.max'));
            return $class::whereIn('id', $keys)->get();
        };
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        
        $router->bind('books', $this->createBinding(\App\Book::class));
        $router->bind('authors', $this->createBinding(\App\Author::class));
        $router->bind('keywords', $this->createBinding(\App\Keyword::class, 'term'));

        $router->bind('keyword', function($value){
            return Keyword::findBySlugOrIdOrFail($value);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
