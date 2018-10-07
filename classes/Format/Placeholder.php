<?php

namespace Neat\Log\Format;

use Neat\Log\Normalize;

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
    public function __invoke(string $level, string $message, array $context): string
    {
        $replace = [];
        foreach (Normalize::strings($context) as $key => $value) {
            $replace['{' . $key . '}'] = $value;
        }

        return strtr($message, $replace);
    }
}
