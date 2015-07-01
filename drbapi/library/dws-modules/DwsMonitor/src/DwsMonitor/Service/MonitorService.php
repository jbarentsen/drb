<?php

/**
 * Forward logging to registered writers.
 * Each writer decides which priority to use
 * It works as a patchboard with zend_log, but we have a central place
 * to add additional information.
 */

namespace DwsMonitor\Service;

use Traversable;
use Zend\Log\Logger;
use Zend\Log\LoggerInterface;

class MonitorService implements LoggerInterface
{

    /**
     * @var array
     */
    private $writers;

    /**
     *
     * @param array $writers
     */
    public function __construct(array $writers = [])
    {
        $this->writers = $writers;
    }

    /**
     * @param integer $priority
     * @param array|Traversable $message
     * @param array $extra
     */
    private function send($priority, $message, $extra = [])
    {
        if (count($this->writers)) {
            foreach ($this->writers as $writer) {
                $writer->report($priority, $message, $extra);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function emerg($message, $extra = [])
    {
        $this->send(Logger::EMERG, $message, $extra);
    }

    /**
     * {@inheritdoc}
     */
    public function alert($message, $extra = [])
    {
        // At the moment we do nothing with priority Alert
    }

    /**
     * {@inheritdoc}
     */
    public function crit($message, $extra = [])
    {
        // At the moment we do nothing with priority Crit
    }

    /**
     * {@inheritdoc}
     */
    public function err($message, $extra = [])
    {
        $this->send(Logger::ERR, $message, $extra);
    }

    /**
     * {@inheritdoc}
     */
    public function warn($message, $extra = [])
    {
        // At the moment we do nothing with priority Warn
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, $extra = [])
    {
        // At the moment we do nothing with priority Notice
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, $extra = [])
    {
        $this->send(Logger::INFO, $message, $extra);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, $extra = [])
    {
        // At the moment we do nothing with priority Debug
    }
}
