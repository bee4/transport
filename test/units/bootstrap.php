<?php
/**
 * PHPUnit tests bootstrap, must contain initialization...
 * @copyright Bee4 2015
 * @author Stéphane HULARD <s.hulard@chstudio.fr>
 */

require __DIR__.'/../webserver.php';

//------------------------------------------------------------------------------
//Use composer for autoloading
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/PHPUnit/HttpClientTestCase.php';

\Bee4\PHPUnit\HttpClientTestCase::setBaseUrl('http://'.WEBSERVER_HOST.':'.WEBSERVER_PORT);
