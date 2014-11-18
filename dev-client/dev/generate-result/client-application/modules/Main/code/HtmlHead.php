<?php
namespace LSite\Main;

class HtmlHead
{
    private $headElements = array();
    
    public function add($headElement) {
        if (!in_array($headElement, $this->headElements)) {
            $this->headElements[] = $headElement;
        }
        return $this;
    }

    public function getheadElements() {
        return $this->headElements;
    }

}