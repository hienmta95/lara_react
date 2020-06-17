<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait ForBaseModel
{
    //--------- SCOPES ---------//
    /**
     * @param  $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        if ($this->forceDeleting) {
            return $query;
        }
        return $query->where(
            function ($query) {
                $query->whereNull($this->table . '.' . $this->getDeletedAtColumn());
            }
        );
    }


    //--------- STATIC ULTILITIES ---------//
    /**
     * Get the table name statically
     *
     * @return string
     */
    public static function table()
    {
        return with(new static)->getTable();
    }

    //--------- ULTILITIES ---------//
    protected function castToId($model)
    {
        if ($model instanceof Model) {
            return $model->id;
        } else {
            return $model;
        }
    }

    protected function castToModel($model, $class)
    {
        if ($model instanceof Model) {
            return $model;
        } else {
            return \call_user_func([$class, 'find'], $model);
        }
    }
}
