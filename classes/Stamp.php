<?php

namespace Neat\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Stamp implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var callable[]
     */
    private $stamps;

    /**
     * Stamp constructor
     *
     * @param LoggerInterface $logger
     * @param callable[]      $stamps
     */
    public function __construct(LoggerInterface $logger, callable ...$stamps)
    {
        $this->logger = $logger;
        $this->stamps = $stamps;
    }

    /**
     * Log message with stamps
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $record = new Record($level, $message, $context);

        $prefix = '';
        foreach ($this->stamps as $stamp) {
            $prefix .= '[' . $stamp($record) . '] ';
        }

        $this->logger->log($record->level(), $prefix . $record->message(), $record->context());
    }
}
