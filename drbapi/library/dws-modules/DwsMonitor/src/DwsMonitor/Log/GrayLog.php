<?php

namespace DwsMonitor\Log;

use DwsMonitor\Log\GrayLog\GrayLogInterface;
use Gelf\Message;
use Gelf\Publisher;
use Zend\Console\Console;

class GrayLog implements GrayLogInterface
{
    /**
     * @var Publisher
     */
    private $publisher;

    /**
     *
     * @param Publisher $publisher
     */
    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * {@inheritdoc}
     */
    public function report($priority, $message, $extra = [])
    {
        $grayLogMessage = new Message();
        $grayLogMessage->setShortMessage($message);
        $grayLogMessage->setFullMessage($extra ? print_r($extra, true) : $message);
        $grayLogMessage->setHost((Console::isConsole() ? 'Console' : $_SERVER['HTTP_HOST']));
        $grayLogMessage->setLevel($priority);
        $grayLogMessage->setTimestamp(time());
        $grayLogMessage->setVersion('1.0');
        $this->publisher->publish($grayLogMessage);
    }
}
