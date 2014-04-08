<?php

/**
 * tinymvc_library_subtitles.php
 *
 * model for getting subtitles on opensubtitles.org
 *
 * @package     JooX 2.0
 * @author      Christoffer Bubach
 */

class TinyMVC_Library_Subtitles {

    /**
     * Search opensubtitles.org for subtitles
     */
    function getSubtitleIds($fileName) {

        $this->controller = tmvc::instance(null, 'controller');
        $this->controller->load->library('httpcall');
        $subtitleIds = array();

        try {
            $url = "http://www.opensubtitles.org/sv/search/sublanguageid-swe/moviename-";
            $urlReadyName = urlencode(str_replace(".mp4", "", $fileName));
            $return  = $this->controller->httpcall->httpCall($url.$urlReadyName, array(), "GET", "");
            $html = $return['content'];

            if (strpos($html, '<table id="search_results">') !== FALSE) {
                $html = $this->controller->httpcall->extractBetweenDelimeters($html, '<table id="search_results">', '<div class="footer upfooter">');
                $foundOne = TRUE;

                while (strlen($html) && $foundOne) {
                    $result = $this->controller->httpcall->extractBetweenDelimeters($html, ",'/sv/subtitles/", "/short-on'", 1);

                    if (!empty($result['extracted'])) {
                        $url = "http://www.opensubtitles.org/sv/subtitles/".$result['extracted']."/short-on";
                        $return  = $this->controller->httpcall->httpCall($url, array(), "GET", "");
                        $newHtml = $return['content'];

                        $idRes = $this->controller->httpcall->extractBetweenDelimeters($newHtml, '<a class="none" href="/sv/subtitleserve/file/', '">');
                        $subtitleIds[] = $idRes;
                        $html = substr($html, $result['rightPos']);
                    } else {
                        $foundOne = FALSE;
                    }
                }
            }
        } catch (Exception $e) { return $subtitleIds; }
        return $subtitleIds;
    }

    /**
     * Get subtitle content from opensubtitles.org
     */
    function getSubtitleFile($subtitleId) {

        $this->controller = tmvc::instance(null, 'controller');
        $this->controller->load->library('httpcall');

        $url = "http://www.opensubtitles.org/sv/subtitleserve/file/".$subtitleId;
        $return  = $this->controller->httpcall->httpCall($url, array(), "GET", "");
        
        if (mb_detect_encoding($return['content'], "UTF-8, ISO-8859-1") == "ISO-8859-1") {
            return utf8_encode($return['content']);
        } else {
            return $return['content'];
        }
    }

}
?>