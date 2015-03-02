<?php

// Command that starts the built-in web server
$command = sprintf(
	'php -S %s:%d -t "'.realpath(__DIR__).'/public'.'" >/dev/null 2>&1 & echo $!',
	WEBSERVER_HOST,
	WEBSERVER_PORT
);

// Execute the command and store the process ID
$output = array();
exec($command, $output);
$pid = (int) $output[0];
echo sprintf(
	'%s - Web server started on %s:%d with PID %d',
	date('r'),
	WEBSERVER_HOST,
	WEBSERVER_PORT,
	$pid
) . PHP_EOL;

//Wait a second to let php web server start
sleep(1);

// Kill the web server when the process ends
register_shutdown_function(function() use ($pid) {
	echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
	exec('kill ' . $pid);
});