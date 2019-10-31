<?php

namespace Neat\Log\Filter;

use Neat\Log\Record;

class Pattern
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * Pattern constructor
     *
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Message matches pattern?
     *
     * @param Record $record
     * @return bool
     */
    public function __invoke(Record $record): bool
    {
        return preg_match($this->pattern, $record->message());
    }
}
