<?php

return array(
    'JVLog' => array(
        'notificationMail' => array(
            'notify' => false,
            'priorities' => array(
                '0' => 'Emergency',
                '2' => 'Critical',
                '3' => 'Error',
                '4' => 'Warning',
                '5' => 'Debug'
            ),
            'email' => 'user@domain.com'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'jvlog-log' => 'JVLog\Factory\Log',
            'jvlog-errorhandling' => 'JVLog\Factory\ErrorHandling',
        )
    )
);