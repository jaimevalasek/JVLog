<?php

namespace JVLog\Factory;

use JVLog\Service\ErrorHandling as ServiceErrorHandling;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class ErrorHandling implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $logger = $serviceLocator->get('jvlog-log');
        $serviceLog = new ServiceErrorHandling($serviceLocator, $logger);
        
        return $serviceLog;
    }
}