<?php

namespace Neat\Log;

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
     * Log message after processing it
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $record = new Record($level, $message, $context);

        foreach ($this->formats as $format) {
            $record = $format($record);
        }

        $this->logger->log($record->level(), $record->message(), $record->context());
    }
}
