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
     * Log message using formatter
     *
     * @param mixed $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $prefix = '';
        foreach ($this->stamps as $stamp) {
            $prefix .= '[' . $stamp($level, $message, $context) . '] ';
        }

        $this->logger->log($level, $prefix . $message, $context);
    }
}
