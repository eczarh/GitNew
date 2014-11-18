<?php
namespace LSite;

class Modules {
    private $modules = null;
    
    public function getModules() {
        if (is_null($this->modules)) {
            $this->loadAll();
        }
        return $this->modules;
    }
    
    public function loadAll() {
        $modulesDir = LSITE_MODULES_DIR;
        $directories = scandir($modulesDir);
        foreach ($directories as $moduleName) {
            if (in_array($moduleName, array('.', '..'))) {
                continue;
            }
            $this->modules[$moduleName] = array(
                'config' => array()
            );
            $moduleConfig = $modulesDir . DIRECTORY_SEPARATOR
                          . $moduleName . DIRECTORY_SEPARATOR
                          . 'config.php';
            if (file_exists($moduleConfig)) {
                 $this->modules[$moduleName]['config'] = include $moduleConfig;
            }
        }


    }
}
