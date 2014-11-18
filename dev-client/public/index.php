<?php
error_reporting(-1);
ini_set('short_open_tag', 1);
session_start();

chdir(realpath('../client-application/'));
require 'config.php';
require 'autoloader.php';
require 'service-manager-init.php';

$application = new LSite\Main\Application();
$application->setServiceManager($serviceManager);
$application->run();