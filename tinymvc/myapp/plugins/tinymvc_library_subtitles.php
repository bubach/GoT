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

    var $controller = null;

    function __construct() {
        $this->controller = tmvc::instance(null, 'controller');
        $this->controller->load->library('http');
    }

    /**
     * Search opensubtitles.org for subtitles and
     * return info array with ID and name for each
     * 
     * @param  string     filename to search for
     * @return array      id, name
     */
    function getSubtitleInfo($fileName) {

        $subtitleInfo = array();

        try {
            $url = "http://www.opensubtitles.org/sv/search/sublanguageid-swe/moviename-";
            $urlReadyName = urlencode(str_replace(".mp4", "", $fileName));
            $return  = $this->controller->http->call($url.$urlReadyName, array(), "GET", "");

            preg_match_all("/servOC\(([0-9]+),\'\/\w+\/\w+\/[0-9]+\/([a-z-]+)\/[a-z-]+\',/", $return['content'], $result);
            foreach ($result[1] as $key => $value) {
                $subtitleInfo[] = array($value, $result[2][$key]);
            }
        } catch (Exception $e) { return $subtitleInfo; }
        return $subtitleInfo;
    }

    /**
     * Get subtitle content from opensubtitles.org
     * by reading in the subtitle page, regexing out
     * the URL for the actual subtitle file
     * 
     * @param  integer    the subtitle ID
     * @param  string     subtitle name
     * @return string     utf-8 formatted WEBVTT subtitle string
     */
    function getSubtitleFile($subtitleId, $subtitleName) {

        try {
            $url    = "http://www.opensubtitles.org/sv/subtitles/".$subtitleId."/".$subtitleName."/short-on";
            $return = $this->controller->http->call($url, array(), "GET", "");
            preg_match_all('/\<a class\=\"none\" href\="\/sv\/subtitleserve\/file\/([0-9]+)\"\>/', $return['content'], $result);

            $url     = "http://www.opensubtitles.org/sv/subtitleserve/file/".$result[1][0];
            $return  = $this->controller->http->call($url, array(), "GET", "");

            if (mb_detect_encoding($return['content'], "UTF-8, ISO-8859-1") == "ISO-8859-1") {
                return utf8_encode("WEBVTT\n\r\n\r".$return['content']);
            } else {
                return "WEBVTT\n\r\n\r".$return['content'];
            }
        } catch (Exception $e) {
            return "";
        }
    }

}
?>