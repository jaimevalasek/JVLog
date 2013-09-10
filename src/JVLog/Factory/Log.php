<?php

namespace JVLog\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Log\Writer\Stream as LogStream;
use Zend\Log\Formatter as LogFormatter;
use Zend\Log\Logger as LogLogger;

class Log implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $filename = 'log_' . date('d') . '_' . date('F') . '_' . date('Y') . '.log';
        $logFile = './data/logs/' . $filename;
        
        $logger = new LogLogger();
        $writer = new LogStream($logFile);
        $logger->addWriter($writer);
        
        return $logger;
    }
}