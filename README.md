JVLog - JV Log
================
Create By: Jaime Marcelo Valasek

Use this module to generate and store logs of errors on your site, option to send logs via email using the module JVMail.

Futures video lessons can be developed and published on the website or Youtube channel http://www.zf2.com.br/tutoriais http://www.youtube.com/zf2tutoriais

Installation
-----
Download this module into your vendor folder.
 - Also install the module JVMail - https://github.com/jaimevalasek/JVMail. 

After done the above steps, open the file `config/application.config.php`. And add the module with the name JVLog.


Using the JVLog
-----

 - Access the file that is inside the module.config.php JVLog module and check the settings.
 - The option notify equal true, sends email notification to the email configured below.
 - To send an email notification jvmail the module must be installed, however if you do not use the email notification is not necessary to install it.
 - The logs folder should be created within the directory data being as follows `./data/logs`

```php
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
```

 - Create phtml to send the log via email, if you use the sending via email.
 - Create phtml inside the folder `view/mailtemplates/log-exception.phtml` module of your application.
 
```phtml
<h1><?php echo $this->subject?></h1>
<p>
<?php echo nl2br($this->log)?>
</p>
```