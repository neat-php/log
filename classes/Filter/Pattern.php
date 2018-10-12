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
     * @var bool
     */
    private $exclude;

    /**
     * Pattern constructor
     *
     * @param string $pattern
     * @param bool   $exclude
     */
    public function __construct(string $pattern, bool $exclude = false)
    {
        $this->pattern = $pattern;
        $this->exclude = $exclude;
    }

    /**
     * Message matches pattern?
     *
     * @param Record $record
     * @return bool
     */
    public function __invoke(Record $record): bool
    {
        return $this->exclude xor preg_match($this->pattern, $record->message());
    }
}
