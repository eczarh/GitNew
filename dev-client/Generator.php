<?php
namespace DbCode\client;

class Generator extends CodeGenerator {

    public function generate($from, $to) {
        $this->setSourceDir($from);
        $this->setDestinationDir($to);
        $this->removeDir($to);
        sleep(1);
        mkdir($to, 0777, true);


        $this->copy('/client-application/', '/client-application/');
        $this->copy('/public/', '/public/');
        $this->copy('/deploy.php','/deploy.php');
    }
}

class CodeGenerator {
    private $from = null;
    private $to = null;
    private $configs = null;

    public function setDestinationDir($to) {
        if (!is_dir($to)) {
            throw new \Exception('Dir not found! ' . $to);
        }

        $this->to = $to;
    }
    
    public function setSourceDir($from) {
        if (!is_dir($from)) {
            throw new \Exception('Dir not found! ' . $from);
        }

        $this->from = $from;
    }
    
    public function copy($from, $to) {
        if ($from[0] == '/') {
            $from = substr($from, 1);
        }
        if ($to[0] == '/') {
            $to = substr($to, 1);
        }
        $this->copyR($this->from . $from, $this->to. $to);
    }

    public function copyR($from, $to) {
        if (is_dir($from)) {
            $dirHandle = opendir($from);
            while ($file=readdir($dirHandle)) {
                if ($file != '.' && $file != '..') {
                    if(is_dir($from . '/' . $file)) {
                        if(!is_dir($to . '/' . $file)){
                            mkdir($to . '/' . $file, 0777, true);
                        }
                        $this->copyR($from . '/' . $file, $to . '/' . $file);
                    } else {
                        if (!is_dir(dirname($to . $file))) {
                            mkdir(dirname($to . $file), 0777, true);
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

    public function generateFile($from, $to) {
        if ($from[0] == '/') {
            $from = substr($from, 1);
        }
        if ($to[0] == '/') {
            $to = substr($to, 1);
        }

        $fromFileName = $this->from . $from;
        $resultDir = dirname($this->to . $to) . '/';
        $toFileName = $this->to . $to;

        if (!is_dir($resultDir)) {
            mkdir($resultDir, 0777, true);
        }
        file_put_contents(
            $toFileName,
            include $fromFileName
        );


    }

    public function getConfig($config) {
        if (isset($this->configs[$config]) && ($this->configs[$config] === true)) {
            return true;
        }
        return false;
    }

    public function setConfig($config, $value) {
        $this->configs[$config] = $value;
    }
    
    public function removeDir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . '/' . $object) == 'dir') {
                        $this->removeDir($dir . '/' . $object);
                    } else {
                        unlink( $dir . '/' . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

}
