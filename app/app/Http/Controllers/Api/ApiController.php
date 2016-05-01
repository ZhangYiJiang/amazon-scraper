<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    protected $excluded = [];

    protected $related = [];

    protected $included = [];
    
    public function index(Request $request)
    {
        // Handle pagination
        $page = $request->input('page', 1);
        $pageSize = $request->input('pagesize', config('api.pagesize.default'));
        $pageSize = min($pageSize, config('api.pagesize.max'));

        $model = $this->getModel();

        $resources = $model::skip(($page - 1) * $page)
            ->take($pageSize)
            ->get();

        $resources = $this->filter($resources, $request);
        return $this->constructResponse($resources, $request);
    }

    public function show($models, Request $request)
    {
        $resources = $this->filter($models, $request);
        return $this->constructResponse($resources, $request);
    }

    protected function constructResponse($resources, Request $request)
    {
        $wrapper = [
            'items' => $resources->toArray(),
        ];

        // Remove all null and empty elements
        return response()->json(array_filter_recursive($wrapper, 'strlen'));
    }

    /**
     * @param Collection $models
     * @param Request $request
     * @return mixed
     */
    protected function filter($models, Request $request)
    {
        $fields = explode(';', $request->input('fields'));
        $models->makeHidden($this->getExclusions())->makeVisible($fields);
        $this->loadRelations($models, $fields);

        return $models;
    }

    protected function loadRelations(&$models, $fields)
    {
        if (count($this->related) < 1 || count($models) < 1) return;

        $relations = array_fill_keys($this->included, []);
        foreach ($fields as $field) {
            if (starts_with($field, $this->related)) {
                $segments = explode('.', $field);

                // Check that this is a valid relation
                if (!in_array($segments[0], $this->related))
                    continue;

                if (!array_key_exists($segments[0], $relations)) {
                    $relations[$segments[0]] = [];
                }

                if (count($segments) === 2) {
                    $relations[$segments[0]][] = $segments[1];
                }
            }
        }


        $eager = array_keys($relations);
        $models->load($eager);

        foreach ($relations as $related => $visible) {
            foreach ($models as &$model) {
                $model->makeVisible($related);
                $model->{$related}
                    ->makeHidden(config('api.exclusions.' . $related))
                    ->makeVisible($visible);
            }
        }
    }

    
    private function getExclusions()
    {
        if (is_array($this->excluded)) {
            $excluded = $this->excluded;
        } else {
            $excluded = config('api.exclusions.' . $this->excluded, []);
        }

        return $excluded;
    }

    abstract protected function getModel();
}