<?php

namespace App\Http\Controllers\Logging;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class CustomLogger extends AbstractLogger implements LoggerInterface
{

//    protected $logger;
//
//    public function __construct(Bugsnag $bugsnag)
//    {
//        $this->logger = $bugsnag;
//    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        switch ($level) {
            case 'critical':
                Bugsnag::notifyError('test', 'test');
                break;
        }
    }

}
