<?php

namespace Neat\Log;

use Psr\Log\LogLevel;

class Record
{
    /**
     * @see https://secure.php.net/manual/en/network.constants.php
     */
    const PRIORITIES = [
        LogLevel::EMERGENCY => LOG_EMERG,
        LogLevel::ALERT     => LOG_ALERT,
        LogLevel::CRITICAL  => LOG_CRIT,
        LogLevel::ERROR     => LOG_ERR,
        LogLevel::WARNING   => LOG_WARNING,
        LogLevel::NOTICE    => LOG_NOTICE,
        LogLevel::INFO      => LOG_INFO,
        LogLevel::DEBUG     => LOG_DEBUG,
    ];

    /**
     * @var string
     */
    private $level;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $context;

    /**
     * Message constructor
     *
     * @param mixed $level
     * @param mixed $message
     * @param array $context
     */
    public function __construct($level, $message, array $context = [])
    {
        $this->level   = $this->string($level);
        $this->message = $this->string($message);
        $this->context = $context;
    }

    /**
     * Convert any value to string
     *
     * @param $value
     * @return string
     */
    public function string($value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_object($value)) {
            return method_exists($value, '__toString') ? strval($value) : get_class($value);
        }
        if (is_array($value)) {
            return 'array';
        }

        return json_encode($value);
    }

    /**
     * Get level
     *
     * @return string
     */
    public function level(): string
    {
        return $this->level;
    }

    /**
     * Get priority
     *
     * @return int|null
     */
    public function priority()
    {
        return self::PRIORITIES[$this->level] ?? null;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * Get context
     *
     * @return array
     */
    public function context(): array
    {
        return $this->context;
    }

    /**
     * Get context as array of strings
     *
     * @return string[]
     */
    public function contextStrings()
    {
        return array_map([$this, 'string'], $this->context);
    }

    /**
     * Get new message with level
     *
     * @param string $level
     * @return Record
     */
    public function withLevel(string $level): Record
    {
        $new = clone $this;
        $new->level = $level;

        return $new;
    }

    /**
     * Get new message with message
     *
     * @param string $message
     * @return Record
     */
    public function withMessage(string $message): Record
    {
        $new = clone $this;
        $new->message = $message;

        return $new;
    }

    /**
     * Get new message with context
     *
     * @param array $context
     * @return Record
     */
    public function withContext(array $context): Record
    {
        $new = clone $this;
        $new->context = $context;

        return $new;
    }
}
