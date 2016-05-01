<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['edition', 'price',];

    protected $visible = ['edition', 'price'];

    protected $casts = [
        'price' => 'float'
    ];

    public function book() 
    {
        return $this->belongsTo('App\Book');
    }
}
