<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait Enumerate
{
    /**
     * Setting for enum fields
     * @var array
     */
    public static function enum()
    {
        return [];
    }

    /**
     * Handle dynamic method calls into the model.
     * This is override for calling dynamic enum methods
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        /* process for enum check method call */
        [$field, $value] = $this->getEnumCheckFunc($method);
        if ($field !== null && $value !== null) {
            return $this->executeEnumCheckFunc($field, $value);
        }
        /* process for enum key method call */
        $field = $this->getEnumKeyFunc($method);
        if ($field !== null) {
            return $this->executeEnumKeyFunc($field);
        }
        /* call parent otherwise*/
        return parent::__call($method, $parameters);
    }

    private function getEnumCheckFunc($method)
    {
        if (strpos($method, 'is') !== 0) return null;
        $enumKey = Str::snake(substr($method, 2));
        foreach (self::enum() as $field => $mapping) {
            if (isset($mapping[$enumKey])) {
                return [$field, $mapping[$enumKey]];
            }
        }
        return [null, null];
    }

    private function executeEnumCheckFunc($field, $value)
    {
        return $this->$field == $value;
    }

    private function getEnumKeyFunc($method)
    {
        if (strpos($method, 'enum') !== 0) return null;
        return Str::snake(substr($method, 4));
    }

    private function executeEnumKeyFunc($field)
    {
        return self::enumKey($field, $this->$field);
    }

    /**
     * Get the key from value of an enum
     * @return mixed
     */
    public static function enumKey($field, $value)
    {
        return array_search($value, self::enum()[$field]);
    }

    /**
     * Get the value from key of an enum
     * @return mixed
     */
    public static function enumVal($key)
    {
        return Arr::get(self::enum(), $key);
    }

    /**
     * Get the value mapping of the enum field
     * @return mixed
     */
    public static function enumSet($field)
    {
        return self::enum()[$field];
    }

    /**
     * Get the keys array of an enum
     * @return mixed
     */
    public static function enumKeys($field)
    {
        return array_keys(self::enum()[$field]);
    }

    /**
     * Get the values array of an enum
     * @return mixed
     */
    public static function enumVals($field)
    {
        return array_values(self::enum()[$field]);
    }

    /**
     * Get the values array of an enum
     * @return mixed
     */
    public function toEnumKey($field)
    {
        return array_search($this->$field, self::enum()[$field]);
    }
}
