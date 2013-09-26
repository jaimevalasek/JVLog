<?php

/**
 * LICENSE
 *
 * Copyright (c) 2013, Jaime Marcelo Valasek / ZF2 Tutoriais Brasil
 * http://www.zf2.com.br / http://www.valasek.com.br
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:

 *  * Redistributions of source code must retain the above copyright notice, this
 *    list of conditions and the following disclaimer.

 *  * Redistributions in binary form must reproduce the above copyright notice, this
 *    list of conditions and the following disclaimer in the documentation and/or
 *    other materials provided with the distribution.

 *  * Neither the name of the {organization} nor the names of its
 *    contributors may be used to endorse or promote products derived from
 *    this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @package JVLog
 * @author Jaime Marcelo Valasek! <jaime.valasek@gmail.com>
 * @copyright Copyright (c) 2013-2013 Jaime Marcelo Valasek.
 * @link http://www.valasek.com.br / http://www.zf2.com.br
 */

namespace JVLog;

use Zend\Mvc\MvcEvent;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface
{
    protected $finishLog = true;
    
    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('dispatch.error', function($event)
        {
            $exception = $event->getResult()->exception;
            if ($exception) {
                $sm = $event->getApplication()->getServiceManager();
                $serviceLog = $sm->get('jvlog-errorhandling');
                $serviceLog->logException($exception);
            }
            
            $this->finishLog = false;
        });
        
        $eventManager->attach('finish', function($event)
        {
            if ($this->finishLog) 
            {
                $result = $event->getResult();
                $events = method_exists($result, 'getVariables') ? $result->getVariables() : false;
                $exception = isset($events['exception']) ? $events['exception'] : false;
                if ($exception) {
                    $sm = $event->getApplication()->getServiceManager();
                    $serviceLog = $sm->get('jvlog-errorhandling');
                    $serviceLog->logException($exception);
                }
            }
        });
    }
    
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
				)
			)
		);
	}
	
	public function getConfig()
	{
	    return include __DIR__ . '/config/module.config.php';
	}
}