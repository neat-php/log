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
        $level   = Normalize::string($level);
        $message = Normalize::string($message);

        foreach ($this->filters as $filter) {
            if (!$filter($level, $message, $context)) {
                return;
            }
        }

        $this->logger->log($level, $message, $context);
    }
}
