<?php

namespace App\Models;

class Post extends BaseModel
{
    protected $fillable = [
        'title',
        'body',
        'image',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
