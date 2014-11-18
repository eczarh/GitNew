<?php
namespace LSite;

class Ajax {

    function error($error, $errorsData = array()) {
        $resultXml = '<?xml version="1.0" encoding="utf-8"?>';
        $resultXml .= '<xmlresponse>';
        $resultXml .= '<status>error</status>';
        $resultXml .= '<errors><![CDATA[';
        $resultXml .= $error;
        $resultXml .= ']]></errors>';
        if (count($errorsData) > 0) {
            foreach ($errorsData as $errorDataName => $errorDataValue) {
                $resultXml .= '<' . $errorDataName . '><![CDATA[';
                $resultXml .= $errorDataValue;
                $resultXml .= ']]></' . $errorDataName . '>';
            }
        }
        $resultXml .= '</xmlresponse>';
        return $resultXml;
    }

    function success($resultHtml = '') {
        $resultXml = '<?xml version="1.0" encoding="utf-8"?>';
        $resultXml .= '<xmlresponse>';
        $resultXml .= '<status>success</status>';
        if (!empty($resultHtml)) {
            $resultXml .= '<resulthtml><![CDATA[';
            $resultXml .= $resultHtml;
            $resultXml .= ']]></resulthtml>';
        }
        $resultXml .= '</xmlresponse>';
        return $resultXml;
    }
}
