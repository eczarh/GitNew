<?php
namespace LSite\Main\Controllers;

class Main
{
    protected $serviceManager;

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }
    
    public function error404() {
        $sm = $this->getServiceManager();
        header('HTTP/1.0 404 Not Found');
        return include LSITE_MODULES_DIR . 'Main/templates/error-404.php';
    }

    public function jsConstantsList() {
        $sm = $this->getServiceManager();
        header('Content-Type: application/javascript');
        $templateFilename = LSITE_MODULES_DIR . 'Main/templates/site-langcs.php';
        return include $templateFilename;
    }
}