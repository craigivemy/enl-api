<?php

namespace App\Http\Controllers\Logging;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag as Logger;

class CustomLogger extends AbstractLogger implements LoggerInterface
{

    private $logger;

    public function __construct(Logger $bugsnag)
    {
        $this->logger = $bugsnag;
    }

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
            case 'emergency':
            case 'alert':
            case 'critical':
                $this->logger::notifyException($context['exception'], function($report) {
                    $report->setSeverity('error');
                });
                break;
            case 'error':
                break;
            case 'warning':
                break;
            case 'notice':
                break;
            case 'info':
                break;
            case 'debug':
                break;

        }
    }

}
