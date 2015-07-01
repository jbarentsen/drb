<?php

namespace DwsMonitor\Log\GrayLog;

interface GrayLogInterface
{

    /**
     * @param string $priority
     * @param string $grayLogMessage
     * @param array $extra
     * @return void
     */
    public function report($priority, $grayLogMessage, $extra);
}
