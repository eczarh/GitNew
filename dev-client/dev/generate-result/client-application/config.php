<?php
define('LSITE_CORE_DIR',    __DIR__ . '/core/');
define('LSITE_LAYOUTS_DIR', __DIR__ . '/layouts/');
define('LSITE_MODULES_DIR', __DIR__ . '/modules/');

$mysqliConfig = array(
    'host'          => 'p:MYSQL_HOST',
    'username'      => 'MYSQL_USER',
    'password'      => 'MYSQL_PASSWORD',
    'database'      => 'MYSQL_DATABASE',
    'prefix'        => 'MYSQL_PREFIX'
);

define(
    'MAIL_HEADERS_DEFAULT',
    "Content-type: text/html; charset=utf-8 \r\n"
        . "From: Сайт <noreply@" . $_SERVER['HTTP_HOST'] . "> \r\n"
        . "Reply-To: Сайт <noreply@" . $_SERVER['HTTP_HOST'] . "> \r\n"
);
