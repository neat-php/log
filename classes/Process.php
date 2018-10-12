<?php

namespace Neat\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Process implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var callable[]
     */
    private $processors;

    /**
     * Processor constructor
     *
     * @param LoggerInterface $logger
     * @param callable[]      $processors
     */
    public function __construct(LoggerInterface $logger, callable ...$processors)
    {
        $this->logger     = $logger;
        $this->processors = $processors;
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

        foreach ($this->processors as $processor) {
            $record = $processor($record);
        }

        $this->logger->log($record->level(), $record->message(), $record->context());
    }
}
