<?php

namespace Neat\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class File implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @var string
     */
    private $logfile;

    /**
     * @var resource
     */
    private $handle;

    /**
     * Constructor
     *
     * @param string $logfile
     */
    public function __construct(string $logfile)
    {
        $this->logfile = $logfile;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if ($this->handle) {
            fclose($this->handle);
        }
    }

    /**
     * Get handle
     *
     * @return bool|resource
     */
    private function handle()
    {
        if (!$this->handle) {
            set_error_handler(function() {});
            $directory = dirname($this->logfile);
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $this->handle = fopen($this->logfile, 'a');
            restore_error_handler();
        }

        return $this->handle;
    }

    /**
     * Logs with an arbitrary level
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $handle = $this->handle();
        if ($handle) {
            fwrite($handle, $message . PHP_EOL);
        }
    }
}
