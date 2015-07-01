<?php

namespace DwsMonitor\Log;

use Traversable;
use Zend\Log\Logger;
use Zend\Log\LoggerInterface;

class FileLog implements LoggerInterface
{

    /**
     * @var LoggerInterface $log
     */
    private $log;

    /**
     *
     * @param LoggerInterface $log |null
     */
    public function __construct(LoggerInterface $log = null)
    {
        $this->log = $log;
    }

    /**
     * {@inheritdoc}
     */
    public function report($priority, $message, $extra = [])
    {
        if ($this->log === null) {
            return;
        }
        switch ($priority) {
            case Logger::EMERG:
                $this->log->emerg($message, $extra);
                break;
            case Logger::ERR:
                $this->log->err($message, $extra);
                break;
            default:
                break;
        }
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function emerg($message, $extra = [])
    {
        // TODO: Implement emerg() method.
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function alert($message, $extra = [])
    {
        // TODO: Implement alert() method.
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function crit($message, $extra = [])
    {
        // TODO: Implement crit() method.
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function err($message, $extra = [])
    {
        // TODO: Implement err() method.
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function warn($message, $extra = [])
    {
        // TODO: Implement warn() method.
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function notice($message, $extra = [])
    {
        // TODO: Implement notice() method.
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function info($message, $extra = [])
    {
        // TODO: Implement info() method.
    }

    /**
     * @param string $message
     * @param array|Traversable $extra
     * @return LoggerInterface
     */
    public function debug($message, $extra = [])
    {
        // TODO: Implement debug() method.
    }
}
