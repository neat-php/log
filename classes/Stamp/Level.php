<?php

namespace Neat\Log\Stamp;

use Neat\Log\Record;

class Level
{
    /**
     * Format message with level
     *
     * @param Record $record
     * @return string
     */
    public function __invoke(Record $record): string
    {
        return $record->level();
    }
}
