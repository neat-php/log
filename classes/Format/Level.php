<?php

namespace Neat\Log\Format;

class Level
{
    /**
     * Format message with level
     *
     * @param string $level
     * @param string $message
     * @return string
     */
    public function __invoke(string $level, string $message): string
    {
        return sprintf('[%s] %s', $level, $message);
    }
}
