<?php
namespace LSite;

class ServiceManager
{
    protected $services;
    protected $lazyServices;
    
    public function __construct() {
        $this->services = array();
        $this->lazyServices = array();
    }
    
    private function checkLazyService($name) {
        if (array_key_exists($name, $this->lazyServices)) {
            $parameters = $this->lazyServices[$name];
            $className = $parameters['class'];
            if (
                isset($parameters['constructorParameters'])
                &&
                count($parameters['constructorParameters'] > 0)
            ) {
                $object = new $className($parameters['constructorParameters']);
            } else {
                $object = new $className();
            }
            if (method_exists($object, 'setServiceManager')) {
                $object->setServiceManager($this);
            }
            $this->services[$name] = $object;
        }
    }
    
    private function checkLSiteNamespace($className) {
        if (
            substr($className, 0, 5) == 'LSite'
            ||
            substr($className, 0, 6) == '\LSite'
        ) {
            $object = new $className();
            if (method_exists($object, 'setServiceManager')) {
                $object->setServiceManager($this);
            }
            $this->services[$className] = $object;
        }
    }
    
    private function checkOznakaNamespace($className) {
        if (
            substr($className, 0, 6) == 'Oznaka'
            ||
            substr($className, 0, 7) == '\Oznaka'
        ) {
            $object = new $className();
            if (method_exists($object, 'setServiceManager')) {
                $object->setServiceManager($this);
            }
            $this->services[$className] = $object;
        }
    }
    
    public function get($name) {
        if (array_key_exists($name, $this->services)) {
            return $this->services[$name];
        }

        $this->checkLazyService($name);
        $this->checkLSiteNamespace($name);
        $this->checkOznakaNamespace($name);
        
        if (array_key_exists($name, $this->services)) {
            return $this->services[$name];
        }

        throw new \Exception('Сервис "' . $name . '" не найден!');
    }
    
    public function has($name) {
        if (array_key_exists($name, $this->services)) {
            return true;
        }
        
        if (array_key_exists($name, $this->lazyServices)) {
            return true;
        }
        return false;
    }
    
    public function setLazyService($name, $parameters = array()) {
        if ($this->has($name)) {
            throw new \Exception('Не удалось добавить lazy-сервис. Сервис уже присутствует!');
        }
        $this->lazyServices[$name] = $parameters;
    }
    
    public function setService($name, $service) {
        if ($this->has($name)) {
            throw new \Exception('Не удалось добавить сервис. Сервис уже присутствует!');
        }
        $this->services[$name] = $service;
    }
}