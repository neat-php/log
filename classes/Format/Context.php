<?php

namespace Neat\Log\Format;

use Neat\Log\Normalize;

class Context
{
    /**
     * @var array
     */
    private $blocks;

    /**
     * Context constructor
     *
     * @param array $blocks Context keys that should be rendered as multi-line block (optional)
     */
    public function __construct(array $blocks = [])
    {
        $this->blocks = array_flip($blocks);
    }

    /**
     * Format message with context
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     * @return string
     */
    public function __invoke(string $level, string $message, array $context): string
    {
        $context = Normalize::strings($context);

        $lines  = array_diff_key($context, $this->blocks);
        $blocks = array_intersect_key($context, $this->blocks);

        return $message . $this->formatLines($lines) . $this->formatBlocks($blocks);
    }

    /**
     * Format lines
     *
     * @param array $lines
     * @return string
     */
    private function formatLines(array $lines)
    {
        $max = max(array_map('strlen', array_keys($lines))) + 1;

        return implode('', array_map(function ($key, $value) use ($max) {
            return sprintf("\n%-{$max}s %s", $key . ':', $value);
        }, array_keys($lines), $lines));
    }

    /**
     * Format blocks
     *
     * @param array $blocks
     * @return string
     */
    private function formatBlocks(array $blocks)
    {
        return implode('', array_map(function ($key, $value) {
            return sprintf("\n\n%s\n%s\n\n%s\n", $key, str_repeat('-', strlen($key)), $value);
        }, array_keys($blocks), $blocks));
    }
}
