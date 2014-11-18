<?php
namespace LSite\Main;

class Router
{
    protected $serviceManager;
    
    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function setServiceManager($serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function dispatch() {
        $sm = $this->getServiceManager();
        $response = $sm->get('LSite\Response');
        
        $modules = $sm->get('modules')->getModules();
        $siteLangCodeAdditional = $sm->get('LSite\Lang')->getSiteLangCodeAdditional();

        foreach ($modules as $moduleName => $moduleData) {
            // обходим модули, ищем route-ы
            if (isset($moduleData['config']) && isset($moduleData['config']['routes'])) {
                $moduleRoutes = $moduleData['config']['routes'];
                for ($i = 0; $i < count($moduleRoutes); $i++) {
                    // route-ы внутри модуля найдены - выполняем поиск
                    $moduleRoute = $moduleRoutes[$i];
                    switch($moduleRoute['matchType']) {
                        case 'simple':
                            // простое совпадение по $_SERVER['REQUEST_URI']
                            $matchParams = $moduleRoute['matchParams'];
                            $matchArray = array();
                            foreach ($matchParams as $matchParam) {
                                $matchArray[$matchParam] = 1;
                                foreach ($siteLangCodeAdditional as $siteLangCodeAdditionalItem) {
                                    $matchArray['/' . $siteLangCodeAdditionalItem . $matchParam] = 1;
                                }
                            }
                            if (isset($matchArray[$_SERVER['REQUEST_URI']])) {
                                if ($moduleRoute['type'] == 'contentInLayout') {
                                    $response->setContent(
                                        $sm->get($moduleRoute['class'])->$moduleRoute['method']()
                                    );
                                    $response->setType('contentInLayout');
                                    $response->setLayout(LSITE_LAYOUTS_DIR . $moduleRoute['layout']);
                                    return $response;
                                } elseif ($moduleRoute['type'] == 'ajax') {
                                    $response->setContent(
                                        $sm->get($moduleRoute['class'])->$moduleRoute['method']()
                                    );
                                    $response->setType('ajax');
                                    return $response;
                                } elseif ($moduleRoute['type'] == 'contentOnly') {
                                    $response->setContent(
                                        $sm->get($moduleRoute['class'])->$moduleRoute['method']()
                                    );
                                    $response->setType('contentOnly');
                                    return $response;
                                }
                            }
                            break;
                        case 'regexp':
                            // совпадение по регулярному выражению
                            $matchParams = $moduleRoute['matchParams'];
                            $matchArray = array();
                            foreach ($matchParams as $matchParam) {
                                $matchArray[] = '#^' . $matchParam . '$#';
                                foreach ($siteLangCodeAdditional as $siteLangCodeAdditionalItem) {
                                    $matchArray[] = '#^/' . $siteLangCodeAdditionalItem . $matchParam . '$#';
                                }
                            }
                            foreach ($matchArray as $matchPattern) {
                                if (preg_match($matchPattern, $_SERVER['REQUEST_URI'])) {
                                    if ($moduleRoute['type'] == 'contentInLayout') {
                                        $response->setContent(
                                            $sm->get($moduleRoute['class'])->$moduleRoute['method']()
                                        );
                                        $response->setType('contentInLayout');
                                        $response->setLayout(LSITE_LAYOUTS_DIR . $moduleRoute['layout']);
                                        return $response;
                                    } elseif ($moduleRoute['type'] == 'ajax') {
                                        $response->setContent(
                                            $sm->get($moduleRoute['class'])->$moduleRoute['method']()
                                        );
                                        $response->setType('ajax');
                                        return $response;
                                    } elseif ($moduleRoute['type'] == 'contentOnly') {
                                        $response->setContent(
                                            $sm->get($moduleRoute['class'])->$moduleRoute['method']()
                                        );
                                        $response->setType('contentOnly');
                                        return $response;
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }
        
        $response->setContent($sm->get('LSite\Main\Controllers\Main')->error404());
        $response->setType('contentOnly');
        return $response;
    }
}