<?php

namespace Neat\Log\Filter;

class Pattern
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var bool
     */
    private $exclude;

    /**
     * Pattern constructor
     *
     * @param string $pattern
     * @param bool   $exclude
     */
    public function __construct(string $pattern, bool $exclude = false)
    {
        $this->pattern = $pattern;
        $this->exclude = $exclude;
    }

    /**
     * Message matches pattern?
     *
     * @param string $level
     * @param string $message
     * @return bool
     */
    public function __invoke(string $level, string $message): bool
    {
        return $this->exclude xor preg_match($this->pattern, $message);
    }
}
