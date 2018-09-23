<?php

namespace Neat\Log\Filter;

use Neat\Log\Level;

class Severity
{
    /**
     * @var int
     */
    private $severity;

    /**
     * Severity constructor
     *
     * @param string $level
     */
    public function __construct(string $level)
    {
        $this->severity = Level::PRIORITIES[$level] ?? null;
    }

    /**
     * Level has severity?
     *
     * @param string $level
     * @return bool
     */
    public function __invoke(string $level): bool
    {
        $severity = Level::PRIORITIES[$level] ?? null;

        return $this->severity === null
            || $severity === null
            || $severity <= $this->severity;
    }
}
