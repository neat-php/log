<?php

namespace Neat\Log\Format;

use LogicException;
use Neat\Log\Record;

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
     * @param Record $record
     * @return Record
     */
    public function __invoke(Record $record): Record
    {
        $message = $record->message();
        if (strlen($message) <= $this->length) {
            return $record;
        }

        return $record->withMessage(
            substr($message, 0, $this->length - strlen($this->overflow)) . $this->overflow
        );
    }
}
