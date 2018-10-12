<?php

namespace Neat\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Filter implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var callable[]
     */
    private $filters;

    /**
     * Filter constructor
     *
     * @param LoggerInterface $logger
     * @param callable[]      $filters
     */
    public function __construct(LoggerInterface $logger, callable ...$filters)
    {
        $this->logger  = $logger;
        $this->filters = $filters;
    }

    /**
     * Log message when all filters allow it
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $record = new Record($level, $message, $context);

        foreach ($this->filters as $filter) {
            if (!$filter($record)) {
                return;
            }
        }

        $this->logger->log($record->level(), $record->message(), $record->context());
    }
}
