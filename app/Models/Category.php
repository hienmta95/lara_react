<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $fillable = [
        'parent_id',
        'title',
        'description'
    ];

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
}
