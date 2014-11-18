<?php
namespace Oznaka\Mainpage\Controllers;

class Mainpage
{
    protected $serviceManager;

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function start() {
        $sm = $this->getServiceManager();

        $settings = $sm->get('Oznaka\Mainpage\Models\Mainpage')->getSettings();
        $sm->get('LSite\Main\Seo')->setPageTitle($settings->tagTitle)
                                  ->setMetaKeywords($settings->metaKeywords)
                                  ->setMetaDescription($settings->metaDescription);

        $templateFilename = LSITE_MODULES_DIR . 'Mainpage/templates/start.php';
        return include $templateFilename;
    }

}