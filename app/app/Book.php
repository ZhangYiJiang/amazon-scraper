<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Book extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
    ];

    protected $with = ['prices', 'authors'];

    protected $casts = [
        'rating' => 'real'
    ];
    
    protected $guarded = ['id', 'updated_at', 'created_at'];

    protected $hidden = ['created_at', 'pivot', 'updated_at', 'slug', 'asin', 'isbn', 'rating'];

    public function keywords()
    {
        return $this->belongsToMany('App\Keyword');
    }

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Author');
    }

    public function updatePrices($prices)
    {
        $this->load('prices');
    }
}
