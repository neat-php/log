<?php

namespace Neat\Log\Filter;

use Neat\Log\Record;

class Severity
{
    /**
     * @var int
     */
    private $severity;

    /**
     * Severity constructor
     *
     * @param string $level
     */
    public function __construct(string $level)
    {
        $this->severity = Record::PRIORITIES[$level] ?? LOG_DEBUG;
    }

    /**
     * Level has severity?
     *
     * @param Record $record
     * @return bool
     */
    public function __invoke(Record $record): bool
    {
        $severity = $record->priority() ?? LOG_EMERG;

        return $severity <= $this->severity;
    }
}
