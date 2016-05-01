<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'term',
    ];

    protected $hidden = ['created_at'];

    public function books()
    {
        return $this->belongsToMany('App\Book');
    }
}
