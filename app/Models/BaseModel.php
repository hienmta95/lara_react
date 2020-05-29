<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ForBaseModel;

class BaseModel extends Model
{
    use ForBaseModel;

    //--------- PROPERTIES ---------//
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    //--------- ACCESSORS ---------//

    //--------- SCOPES ---------//

    //--------- PRESENTERS ---------//

    //--------- STATIC ULTILITIES ---------//
}
