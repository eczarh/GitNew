<?php
require_once(__DIR__ . '/../Generator.php');

$funcOptions = array(
    // 'content', 'map'
    );
$longopts = array();
foreach ($funcOptions as $funcOption) {
    $longopts[] = $funcOption . '::';
}

$cliOptions = getopt('h::s::', $longopts);
if (isset($cliOptions['h'])) {
    echo 'Options: ' . PHP_EOL;
    echo '-h : show help' . PHP_EOL;
    echo '-s : deploy code on test site' . PHP_EOL;
    // echo '--content : enable content' . PHP_EOL;
    // echo '--map : enable HTML-code for map' . PHP_EOL;
    exit();
}

$generatorClass = 'DbCode\client\Generator';
$generator = new $generatorClass();

foreach ($funcOptions as $funcOption) {
    if (isset($cliOptions[$funcOption])) {
        $generator->setConfig($funcOption, true);
    } else {
        $generator->setConfig($funcOption, false);
    }
}

$from = str_replace(
    DIRECTORY_SEPARATOR,
    '/',
    realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR
);
$to = str_replace(
    DIRECTORY_SEPARATOR,
    '/',
    __DIR__ . DIRECTORY_SEPARATOR . 'generate-result' . DIRECTORY_SEPARATOR
);
$generator->generate($from, $to);

// развертывание на сайте
{
    if (!isset($cliOptions['s'])) {
        exit();
    }

    if (!function_exists('copyR')) {
        function copyR($from, $to) {
            if (is_dir($from)) {
                $dirHandle = opendir($from);
                while ($file=readdir($dirHandle)) {
                    if ($file != '.' && $file != '..') {
                        if(is_dir($from . '/' . $file)) {
                            if(!is_dir($to . '/' . $file)){
                                mkdir($to . '/' . $file, 0777, true);
                            }
                            copyR($from . '/' . $file, $to . '/' . $file);
                        } else {
                            if (!is_dir(dirname($to . '/' . $file))) {
                                mkdir(dirname($to . '/' . $file), 0777, true);
                            }
                            copy($from . '/' . $file, $to . '/' . $file);
                        }
                    }
                }
                closedir($dirHandle);
            } else {
                $file = basename($from);
                if(!is_dir(dirname($to))) {
                    mkdir(dirname($to), 0777, true);
                }
                copy($from, $to);
            }
        }
    }

    $generateResultDir = str_replace(
        DIRECTORY_SEPARATOR,
        '/',
        __DIR__ . DIRECTORY_SEPARATOR . 'generate-result' . DIRECTORY_SEPARATOR
    );

    $vhostDir = str_replace(
        DIRECTORY_SEPARATOR,
        '/',
        realpath(__DIR__ . DIRECTORY_SEPARATOR . '../..')
    );
    // ------------- БАЗА ДАННЫХ ------------- \\
    $_SERVER['HTTP_HOST'] = 'localhost';
    require_once($vhostDir . '/public/s_admin/configs/mysql.php');
    define('MYSQL_HOST', 'localhost');
    define('MYSQL_USER', $mysqliConfig['username']);
    define('MYSQL_PREFIX', $mysqliConfig['prefix']);
    define('MYSQL_PASSWORD', $mysqliConfig['password']);
    define('MYSQL_DATABASE', $mysqliConfig['database']);
    copyR($vhostDir . '/client-application/modules/Mainpage/', $vhostDir . '/client-application-backup/modules/Mainpage/');
    $generator->removeDir($vhostDir . '/client-application/');
    include $generateResultDir . 'deploy.php';
    copyR($vhostDir . '/client-application-backup/modules/Mainpage/', $vhostDir . '/client-application/modules/Mainpage/');
    $generator->removeDir($vhostDir . '/client-application-backup/');
}
echo 'done';
exit();