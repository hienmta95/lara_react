<?php

namespace App\Models\Traits;

trait ManagesDisplay
{
    public static $IS_DISPLAY_YES = 1;
    public static $IS_DISPLAY_NO = 0;

    /* The attribute for managing display status of model can be changed here */
    protected $displayAttribute = 'is_display';

    public function isDisplaying()
    {
        return $this->{$this->displayAttribute} == self::$IS_DISPLAY_YES;
    }

    public function isNotDisplaying()
    {
        return $this->{$this->displayAttribute} == self::$IS_DISPLAY_NO;
    }

    /**
     * @param  $query
     * @return mixed
     */
    public function scopeDisplay($query)
    {
        $query->where($this->displayAttribute, self::$IS_DISPLAY_YES);
        return $query;
    }

    /**
     * @param  $query
     * @return mixed
     */
    public function scopeNotDisplay($query)
    {
        $query->where($this->displayAttribute, self::$IS_DISPLAY_NO);
        return $query;
    }
}
