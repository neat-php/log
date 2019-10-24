<?php

namespace Neat\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use RuntimeException;
use TypeError;

class Stream implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var resource
     */
    private $handle;

    /**
     * Constructor
     *
     * @param resource $handle
     */
    public function __construct($handle)
    {
        if (!is_resource($handle)) {
            $method = __METHOD__;
            $type   = gettype($handle);
            throw new TypeError("Argument 1 passed to $method must be of the type resource, $type given");
        }
        $meta = stream_get_meta_data($handle);
        if (!in_array($meta['mode'], ['a', 'a+'])) {
            throw new RuntimeException("Handle is not writable");
        }
        $this->handle = $handle;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        fwrite($this->handle, $message . PHP_EOL);
    }
}
