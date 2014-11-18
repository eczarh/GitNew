<?php
namespace Oznaka\Mainpage\Models;

class Mainpage
{
    protected $serviceManager;

    public function getSettingsTable() {
        return $this->getServiceManager()->get('mysqli')->getPrefix() . 'mainpage_settings';
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function getSettings() {
        $sm = $this->getServiceManager();
        $mysqli = $sm->get('mysqli');

        $siteLangCode = $sm->get('lang')->getLangCode();    
        $sqlQuery = 'SELECT * FROM ' . $this->getSettingsTable()
            . ' WHERE site_lang="' . $mysqli->real_escape_string($siteLangCode) . '"';
        $resultQuery = $mysqli->query($sqlQuery);
        if ($resultQuery === false) {
            return false;
        }
        if (!$resultQuery->num_rows) {
            return false;
        }
        
        $entry = $resultQuery->fetch_assoc();
        $settings = new \stdClass();
        $settings->tagTitle = $entry['tagTitle'];
        $settings->metaKeywords = $entry['metaKeywords'];
        $settings->metaDescription = $entry['metaDescription'];
        return $settings;
    }
}