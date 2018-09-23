<?php

namespace Neat\Log\Format;

use LogicException;

class Truncate
{
    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $overflow;

    /**
     * Truncate constructor
     *
     * @param int    $length
     * @param string $overflow
     */
    public function __construct(int $length, string $overflow = '')
    {
        if (strlen($overflow) > $length) {
            throw new LogicException('Overflow can not be longer than maximum allowed message length.');
        }

        $this->length   = $length;
        $this->overflow = $overflow;
    }

    /**
     * Truncate message
     *
     * @param string $level
     * @param string $message
     * @return string
     */
    public function __invoke(string $level, string $message): string
    {
        if (strlen($message) <= $this->length) {
            return $message;
        }

        return substr($message, 0, $this->length - strlen($this->overflow)) . $this->overflow;
    }
}
