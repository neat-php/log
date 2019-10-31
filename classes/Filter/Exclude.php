<?php

namespace Neat\Log\Filter;

use Neat\Log\Record;

class Exclude
{
    /**
     * @var callable
     */
    private $filter;

    /**
     * Exclude constructor
     *
     * @param callable $filter
     */
    public function __construct(callable $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Exclude filtered record?
     *
     * @param Record $record
     * @return bool
     */
    public function __invoke(Record $record): bool
    {
        return !($this->filter)($record);
    }
}
