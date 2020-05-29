<?php

namespace App\Models;

class Post extends BaseModel
{
    protected $fillable = [
        'title',
        'body',
        'image'
    ];
}
