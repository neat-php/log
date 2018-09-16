<?php

namespace Neat\Log\Format;

class Placeholder
{
    /**
     * Format message with {placeholder} tags
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     * @return string
     * @see https://www.php-fig.org/psr/psr-3/#12-message
     */
    public function __invoke(string $level, string $message, array $context = []): string
    {
        $replace = [];
        foreach ($context as $key => $value) {
            if (!is_array($value) && (!is_object($value) || method_exists($value, '__toString'))) {
                $replace['{' . $key . '}'] = $value;
            }
        }

        return strtr($message, $replace);
    }
}
