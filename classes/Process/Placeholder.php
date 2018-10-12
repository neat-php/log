<?php

namespace Neat\Log\Process;

use Neat\Log\Record;

class Placeholder
{
    /**
     * Format message with {placeholder} tags
     *
     * @param Record $record
     * @return Record
     * @see https://www.php-fig.org/psr/psr-3/#12-message
     */
    public function __invoke(Record $record): Record
    {
        $replace = [];
        foreach ($record->contextStrings() as $key => $value) {
            $replace['{' . $key . '}'] = $value;
        }

        return $record->withMessage(strtr($record->message(), $replace));
    }
}
