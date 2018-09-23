<?php

namespace Neat\Log;

class Normalize
{
    /**
     * Normalize a string value
     *
     * @param mixed $value
     * @return string
     */
    public static function string($value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_object($value)) {
            return method_exists($value, '__toString') ? strval($value) : get_class($value);
        }
        if (is_array($value)) {
            return 'array';
        }

        return json_encode($value);
    }

    /**
     * Normalize an array of string values
     *
     * @param mixed $values
     * @return string[]
     */
    public static function strings($values): array
    {
        return array_map([static::class, 'string'], (array) $values);
    }
}
