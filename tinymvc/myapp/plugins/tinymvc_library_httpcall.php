<?php

/**
 * tinymvc_library_httpcall.php
 *
 * Library for doing HTTP calls with custom headers,
 * and some support functions to manipulate the results.
 *
 * @package     JooX 2.0
 * @author      Christoffer Bubach
 */

class TinyMVC_Library_HTTPCall {

    /**
     * Makes an HTTP request
     * 
     * @param string $url           API or website url
     * @param array $data           GET or POST params
     * @param string $method        GET or POST 
     * @param string $extraHeaders  Example: "Cookie: foo=bar\r\n" 
     * @param array $streamData     Example: array('ssl'=>array('verify_peer'   => true))
     * @return array
     * 
    **/
    function httpCall($url, $data, $method = "GET", $extraHeaders = "", $streamData = array()) {
        $dataUrl = http_build_query($data);
        $dataLen = strlen($dataUrl);

        $streamData['http']['method']  = $method;
        $streamData['http']['header']  = "Connection: close\r\n";
        $streamData['http']['header'] .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $streamData['http']['header'] .= "Content-Length: ".$dataLen."\r\n";
        $streamData['http']['header'] .= $extraHeaders;
        $streamData['http']['content'] = $dataUrl;

        return array (
            'content' => @file_get_contents($url, false, stream_context_create($streamData)),
            'headers' => $http_response_header
        );
    }

    /**
     * Get string between two strings
     * 
     * @param string $inputStr           Input string to search
     * @param string $delimeterLeft      Substring to the left, 0 = start of string
     * @param string $delimeterRight     Substring to the right, 0 = end of string
     * @return string
     * 
    **/
    function extractBetweenDelimeters($inputStr, $delimeterLeft, $delimeterRight, $returnRightPos = 0) {
        if ($delimeterLeft == "") {
            $posLeft  = 0;
        } else {
            $posLeft  = stripos($inputStr, $delimeterLeft) + strlen($delimeterLeft);
        }
        if ($delimeterRight == "") {
            $posRight = strlen($inputStr);
        } else {
            $posRight = stripos($inputStr, $delimeterRight, $posLeft + 1);
        }

        $return = substr($inputStr, $posLeft, $posRight - $posLeft);
        if ($returnRightPos == 0) {
            return $return;
        } else {
            return array('rightPos'=>$posRight, 'extracted'=>$return);
        }
    }

}

?>