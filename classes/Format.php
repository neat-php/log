<?php

namespace Neat\Log;

use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Format implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var callable[]
     */
    private $formats;

    /**
     * Format constructor
     *
     * @param LoggerInterface $logger
     * @param callable[]      $formats
     */
    public function __construct(LoggerInterface $logger, callable ...$formats)
    {
        $this->logger  = $logger;
        $this->formats = $formats;
    }

    /**
     * Log message using formatter
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        if (!is_string($level)) {
            throw new InvalidArgumentException('Log level must be a string, ' . gettype($level) . ' given');
        }

        foreach ($this->formats as $format) {
            $message = $format($level, $message, $context);
        }

        $this->logger->log($level, $message, $context);
    }
}
