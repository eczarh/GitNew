<?php
namespace LSite\Main;

class Seo
{
    private $pageTitle = '';
    private $metaKeywords = '';
    private $metaDescription = '';

    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function setPageTitle($pageTitle) {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    public function getMetaKeywords() {
        return $this->metaKeywords;
    }

    public function setMetaKeywords($metaKeywords) {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    public function getMetaDescription() {
        return $this->metaDescription;
    }

    public function setMetaDescription($metaDescription) {
        $this->metaDescription = $metaDescription;
        return $this;
    }

}