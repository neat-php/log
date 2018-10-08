<?php

namespace Neat\Log;

class Record
{
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
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    public function __construct(string $level, string $message, array $context = [])
    {
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;
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
