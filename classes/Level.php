<?php

namespace Neat\Log;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Level
{
    use LoggerTrait;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Format constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Format message with level
     *
     * @param string $level
     * @param string $message
     * @return string
     */
    private function format(string $level, string $message): string
    {
        return sprintf('[%s] %s', $level, $message);
    }

    /**
     * Log message with level
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        if (!is_string($level)) {
            throw new InvalidArgumentException('Log level must be a string, ' . gettype($level) . ' given');
        }

        $this->logger->log($level, $this->format($level, $message), $context);
    }
}
