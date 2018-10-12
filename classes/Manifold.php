<?php

namespace Neat\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Manifold implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var LoggerInterface[]
     */
    private $loggers;

    /**
     * Format constructor
     *
     * @param LoggerInterface[] $loggers
     */
    public function __construct(LoggerInterface ...$loggers)
    {
        $this->loggers = $loggers;
    }

    /**
     * Log message using many loggers
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        foreach ($this->loggers as $logger) {
            $logger->log($level, $message, $context);
        }
    }
}
