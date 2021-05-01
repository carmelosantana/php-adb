<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use carmelosantana\ADB\ADB;

$adb = new ADB();

// output version
echo $adb->version() . PHP_EOL;

// attempts to start server, returns true if active
echo $adb->startServer() . PHP_EOL;

// wait to see if devices are found
echo "Waiting for devices ..." . PHP_EOL;
sleep(3);

// check for devices
echo ($adb->devices() ? implode(PHP_EOL, $adb->devices()) : "No devices connected.") . PHP_EOL; 

// sometimes you need to restart the server mid session
echo ($adb->killServer() ? 'Server shutdown successfully.' : 'A problem occurred with the server shutdown.') . PHP_EOL;

// if you need to start server as root [no permissions (user in plugdev group; are your udev rules wrong?)] 
// echo $adb->startServer('root') . PHP_EOL;
