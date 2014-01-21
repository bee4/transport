<?php
/**
 * PHPUnit tests bootstrap, must contain initialization...
 * @copyright Bee4 2014
 * @author Stéphane HULARD <s.hulard@chstudio.fr>
 */

// Command that starts the built-in web server
$command = sprintf(
	'php -S %s:%d -t %s >/dev/null 2>&1 & echo $!',
	WEB_SERVER_HOST,
	WEB_SERVER_PORT,
	realpath(WEB_SERVER_DOCROOT)
);

// Execute the command and store the process ID
$output = array();
exec($command, $output);
$pid = (int) $output[0];
echo sprintf(
	'%s - Web server started on %s:%d with PID %d',
	date('r'),
	WEB_SERVER_HOST,
	WEB_SERVER_PORT,
	$pid
) . PHP_EOL;

//Wait a second to let php web server start
sleep(1);

// Kill the web server when the process ends
register_shutdown_function(function() use ($pid) {
	echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
	exec('kill ' . $pid);
});

//------------------------------------------------------------------------------
//Use composer for autoloading
require_once __DIR__.'/../vendor/autoload.php';