<?php

/**
 * tinymvc_library_http.php
 *
 * Library for doing HTTP calls with custom headers,
 * and some support functions to manipulate the results.
 *
 * @package     JooX 2.0
 * @author      Christoffer Bubach
 */

class TinyMVC_Library_HTTP {

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
    function call($url, $data, $method = "GET", $extraHeaders = "", $streamData = array()) {
        $dataUrl = http_build_query($data);
        $dataLen = strlen($dataUrl);

        $streamData['http']['method']  = $method;
        $streamData['http']['header']  = "Connection: close\r\n";
        $streamData['http']['header'] .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $streamData['http']['header'] .= "Content-Length: ".$dataLen."\r\n";
        if (!empty($extraHeaders)) {
            $streamData['http']['header'] .= $extraHeaders;
        }
        $streamData['http']['content'] = $dataUrl;

        $content = $this->url_get_contents($url, $streamData);
        return $content;
    }

    /**
     * Custom url_get_contents() for fallback
     * 
     * @param string $url       The url to open
     * @param array  $context   Call context settings
     * @return string
     *
    **/
    function url_get_contents($url, $context) {

        if (function_exists('file_get_contents') && ini_get('allow_url_fopen')) {
            try {
                $content = @file_get_contents($url, false, stream_context_create($context));
                $headers = $http_response_header;
            } catch (Exception $e) {
                $content = false;
                $headers = false;
            }
        } elseif (function_exists('curl_exec')) {
            try {
                if ($this->array_search_inner($context, 'verify_peer', true)) {
                    $options[CURLOPT_SSL_VERIFYPEER] = true;
                    $options[CURLOPT_SSL_VERIFYHOST] = 2;
                } else {
                    $options[CURLOPT_SSL_VERIFYPEER] = false;
                    $options[CURLOPT_SSL_VERIFYHOST] = false;
                }

                $tmp = $this->array_search_inner($context, 'cafile', '');
                if ($tmp) {
                    $options[CURLOPT_CAINFO]         = $tmp;
                }

                if ($this->array_search_inner($context, 'follow_location', '0')) {
                    $options[CURLOPT_FOLLOWLOCATION] = false;
                } else {
                    $options[CURLOPT_FOLLOWLOCATION] = true;
                }

                if ($this->array_search_inner($context, 'method', 'POST')) {
                    $options[CURLOPT_POSTFIELDS] = $this->array_search_inner($context, 'content', '');
                } else {
                    $url .= '?' . $this->array_search_inner($context, 'content', '');
                }

                $options[CURLOPT_URL]            = $url;
                $options[CURLOPT_RETURNTRANSFER] = true;
                $options[CURLOPT_USERAGENT]      = 'joox/2.0';
                $options[CURLOPT_CONNECTTIMEOUT] = 10;
                $options[CURLOPT_VERBOSE]        = 1;
                $options[CURLOPT_HEADER]         = 1;
                
                $headers = array_filter(explode("\r\n", $this->array_search_inner($context, 'header', '')));
                foreach ($headers as $key => $value) {
                    if (strpos($value, 'Content-Length') !== false) {
                        unset($headers[$key]);
                        break;
                    }
                }
                $options[CURLOPT_HTTPHEADER] = $headers;

                $conn = curl_init();
                curl_setopt_array($conn, $options);
                $response    = curl_exec($conn);
                $header_size = curl_getinfo($conn, CURLINFO_HEADER_SIZE);
                $headers     = array_filter(explode("\r\n", substr($response, 0, $header_size)));
                $content     = substr($response, $header_size);
                curl_close($conn);

            } catch (Exception $e) {
                $content = false;
                $headers = false;
            }
        } else{
            $content   = false;
            $headers   = false;
        }
        return array('content' => $content, 'headers' => $headers);
    }

    /**
     * Search multi-dimentional array for key
     * 
     * @param array $array   The array to look through
     * @param string $attr   The key to look for
     * @param string $val    The value to look for
     * @return mixed         False if not found
     * 
    **/
    function array_search_inner($array, $attr, $val) {

        if (!is_array($array)) {
            return false;
        }

        foreach ($array as $key => $inner) {
            if (!is_array($inner)) {
                return false;
            }
            if (!isset($inner[$attr])) {
                continue;
            }
            if ($inner[$attr] == $val) {
                return $key;
            } elseif ($val == "") {
                return $inner[$attr];
            }
        }
        return false;
    }

    /**
     * Get string between two strings
     * 
     * @param  string $inputStr           Input string to search
     * @param  string $delimeterLeft      Substring to the left, 0 = start of string
     * @param  string $delimeterRight     Substring to the right, 0 = end of string
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

        if ($posLeft === false || $posRight === false) {
            return false;
        } else {
            $return = substr($inputStr, $posLeft, $posRight - $posLeft);
        }

        if ($returnRightPos == 0) {
            return $return;
        } else {
            return array('rightPos'=>($posRight + strlen($delimeterRight)), 'extracted'=>$return);
        }
    }

}

?>