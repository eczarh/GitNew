<?php
define('LSITE_CORE_DIR',    __DIR__ . '/core/');
define('LSITE_LAYOUTS_DIR', __DIR__ . '/layouts/');
define('LSITE_MODULES_DIR', __DIR__ . '/modules/');

$mysqliConfig = array(
    'host'          => 'p:localhost',
    'username'      => 'root',
    'password'      => '123',
    'database'      => 'cmsdb_5',
    'prefix'        => 'abpr_'
);

define(
    'MAIL_HEADERS_DEFAULT',
    "Content-type: text/html; charset=utf-8 \r\n"
        . "From: Сайт <noreply@" . $_SERVER['HTTP_HOST'] . "> \r\n"
        . "Reply-To: Сайт <noreply@" . $_SERVER['HTTP_HOST'] . "> \r\n"
);
