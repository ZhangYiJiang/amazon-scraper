<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Author extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
    ];

    protected $fillable = ['name', 'bio', 'url'];

    protected $hidden = ['pivot', 'bio', 'created_at', 'slug', 'updated_at'];

    public function books()
    {
        return $this->belongsToMany('App\Book');
    }
}
