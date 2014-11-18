<?php
function lsiteAutoloader($className) {
    $className = str_replace('\LSite', 'LSite', $className);
    $className = str_replace('\Oznaka', 'Oznaka', $className);

    $coreClasses = array(
        'LSite\Ajax',
        'LSite\Mysqli',
        'LSite\Lang',
        'LSite\Modules',
        'LSite\Response',
        'LSite\ServiceManager'
    );
    if (in_array($className, $coreClasses)) {
        $shortClassName = str_replace('LSite\\', '', $className);
        require_once(
            LSITE_CORE_DIR . str_replace('\\', '/', $shortClassName) . '.php'
        );
        return;
    }
    if (substr($className, 0, 6) == 'LSite\\') {
        $lsitePattern = <<< 'PATTERN'
#LSite\\([a-zA-Z0-9]+)\\.*#
PATTERN;
        preg_match($lsitePattern, $className, $matches);
        $moduleName = $matches[1];
        $modulePrefix = 'LSite\\' . $matches[1] . '\\';
        $shortClassName = str_replace($modulePrefix, '', $className);
        require_once(
            LSITE_MODULES_DIR . $moduleName . '/code/' . str_replace('\\', '/', $shortClassName) . '.php'
        );
        return;
    }
    if (substr($className, 0, 7) == 'Oznaka\\') {
        $oznakaPattern = <<< 'PATTERN'
#Oznaka\\([a-zA-Z0-9]+)\\.*#
PATTERN;
        preg_match($oznakaPattern, $className, $matches);
        $moduleName = $matches[1];
        $modulePrefix = 'Oznaka\\' . $matches[1] . '\\';
        $shortClassName = str_replace($modulePrefix, '', $className);
        require_once(
            LSITE_MODULES_DIR . $moduleName . '/code/' . str_replace('\\', '/', $shortClassName) . '.php'
        );
        return;
    }
}
spl_autoload_register('lsiteAutoloader');

function zendFrameworkAutoloader($className) {
    $zfClassmap = array(
        'Zend\Escaper\Escaper' 
            => __DIR__ . '/vendor/zf2/Zend/Escaper/Escaper.php',
        'Zend\Escaper\Exception\ExceptionInterface'
            => __DIR__ . '/vendor/zf2/Zend/Escaper/Exception/ExceptionInterface.php',
        'Zend\Escaper\Exception\InvalidArgumentException'
            => __DIR__ . '/vendor/zf2/Zend/Escaper/Exception/InvalidArgumentException.php',
        'Zend\Escaper\Exception\RuntimeException'
            => __DIR__ . '/vendor/zf2/Zend/Escaper/Exception/RuntimeException.php'
    );
    if (array_key_exists($className, $zfClassmap)) {
        require_once($zfClassmap[$className]);
    }
}

spl_autoload_register('zendFrameworkAutoloader');

function lsiteExceptionHandler($exception) {
    switch($exception->getCode()) {
        case 404:
        default:
            global $serviceManager;
            echo $serviceManager->get('LSite\Main\Controllers\Main')->error404();
            exit();
            break;
    }
}

set_exception_handler('lsiteExceptionHandler');