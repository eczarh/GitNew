<?php
namespace LSite\Main;

class Application
{
    protected $serviceManager;
    
    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function run() {
        $sm = $this->getServiceManager();
        $sm->get('lang')->detectLanguage();
        $sm->get('lang')->loadLangConstants();
        $sm->get('modules')->loadAll();
        $response = $sm->get('LSite\Main\Router')->dispatch();
        switch($response->getType()) {
            case 'ajax':
                $resultContent = $response->getContent();
                header("Content-type: text/html; charset=utf-8");
                echo $resultContent;
                break;
            case 'contentInLayout':
                $resultContent = $response->getContent();
                $resultAllCode = include $response->getLayout();
                echo $resultAllCode;
                break;
            case 'contentOnly':
                echo $response->getContent();
                break;
        }
    }
}