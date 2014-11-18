<?php
namespace LSite;

class Lang {
    protected $serviceManager;
    
    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    // основной язык сайта
    protected $siteLangCodeMain = 'ru';
    
    // дополнительные языки сайта
    protected $siteLangCodeAdditional = array();
    public function getSiteLangCodeAdditional() {
        return $this->siteLangCodeAdditional;
    }

    // текущий язык
    protected $siteLangCode = '';
    
    public function getLangCode() {
        return $this->siteLangCode;
    }
    
    public function getLangUrl() {
        if ($this->siteLangMain) {
            return '/';
        }
        return '/' . $this->siteLangCode . '/';
    }
    
    // установленный язый - основной?
    protected $siteLangMain = true;
    
    public function detectLanguage() {
        if (count($this->siteLangCodeAdditional) > 0) {
            // если на сайте > 1 языка - пробуем определить язык
            $pattern = '#^/(' . implode('|', $this->siteLangCodeAdditional) . ')/#';
            if (preg_match($pattern, $_SERVER['REQUEST_URI'], $matches)) {
                $this->siteLangMain = false;
                $this->siteLangCode = $matches[1];
                return $this;
            }
        }
        
        // если основной язык сайта - URL не должен содержать код языка
        $pattern = '#^/(' . $this->siteLangCodeMain . ')/(.*)#';
        if (preg_match($pattern, $_SERVER['REQUEST_URI'], $matches)) {
            header('Location: /' . $matches[2], true, 301);
            exit();
        }
        $this->siteLangMain = true;
        $this->siteLangCode = $this->siteLangCodeMain;
        return $this;
    }
    
    // языковые константы
    protected $langConstants = array();
    
    public function getLangConstants() {
        return $this->langConstants;
    }
    
    public function loadLangConstants() {
        $sm = $this->getServiceManager();
        $modules = $sm->get('modules')->getModules();
        foreach ($modules as $moduleName => $moduleData) {
            $languageFile = LSITE_MODULES_DIR . $moduleName
                            . DIRECTORY_SEPARATOR . 'languages'
                            . DIRECTORY_SEPARATOR . $this->getLangCode() . '.php';
            if (file_exists($languageFile)) {
                $this->langConstants = array_merge($this->langConstants, include $languageFile);
            }
        }
    }

    // получение языковой константы
    public function get($langConstant) {
        if (isset($this->langConstants[$langConstant])) {
            return $this->langConstants[$langConstant];
        }
        return '';
    }

    // установка языковой константы
    public function set($langConstant, $langConstantValue) {
        $langConstants[$langConstant] = $langConstantValue;
    }
}