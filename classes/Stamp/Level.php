<?php

namespace Neat\Log\Stamp;

class Level
{
    /**
     * Format message with level
     *
     * @param string $level
     * @return string
     */
    public function __invoke(string $level): string
    {
        return $level;
    }
}
