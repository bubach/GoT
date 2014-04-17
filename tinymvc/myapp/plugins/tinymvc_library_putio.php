<?php

/**
 * tinymvc_library_putio.php
 *
 * Library for using the put.IO API
 *
 * @package     JooX 2.0
 * @author      Christoffer Bubach
 */

class TinyMVC_Library_PutIO {

    public $accessToken = '50H2K1J7';
    public $apiUrl      = 'https://api.put.io/v2/';

    public $contextOptions = array('ssl' => array(
        'verify_peer'   => true,
        'verify_depth'  => 5,
        'CN_match'      => 'api.put.io'
    ), 'http' => array(
        'follow_location' => 0,
        'max_redirects'   => 0
    ));

    public $controller = null;

    function __construct() {
        $this->controller = tmvc::instance(null, 'controller');
        $this->controller->load->library('http');
    }

    /**
     * Get a list of files based on parent folder ID
     * or 0 for root.
     * 
     * @param  integer  parentId or 0
     * @return array    array with file-info
     * 
     */
    function getFileList($parentId = 0) {

        $data = array(
            'oauth_token' => $this->accessToken,
            'parent_id'   => $parentId
        );
        $url = $this->apiUrl.'files/list';

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';

        $return = $this->controller->http->call($url, $data, "GET", "", $this->contextOptions);
        $tmpRes = json_decode($return['content'], TRUE);
        return $tmpRes['files'];
    }

    /**
     * Get more specified information about fileId
     * 
     * @param   integer   file id
     * @return  array     with file information
     * 
     */
    function getFileInfo($fileId) {

        $data = array('oauth_token' => $this->accessToken);
        $url  = $this->apiUrl.'files/'.$fileId;

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';
        $return = $this->controller->http->call($url, $data, "GET", "", $this->contextOptions);

        if (!array_key_exists('content', $return)) {
            return false;
        }
        $tmpRes = json_decode($return['content'], TRUE);
        return $tmpRes['file'];
    }

    /**
     * Get a files download URL
     * 
     * @param   integer   fileId
     * @param   integer   attachment 1 or 0
     * @return  string    file URL
     * 
     */
    function getFileUrl($fileId, $attachment = 0) {

        $data = array('oauth_token' => $this->accessToken);
        $url  = $this->apiUrl.'files/'.$fileId.'/download';

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';
        $return  = $this->controller->http->call($url, $data, "GET", "", $this->contextOptions);

        $cookie = array();
        foreach ($return['headers'] as $key => $value) {
            $found = preg_match('/set-cookie: ([\w]+)=([\w%]+);/', $value, $cookie);
            if ($found) {
                setcookie($cookie[1], $cookie[2], 0, '/', '.put.io', false, false);
            }
        }

        $fileUrl = $this->controller->http->extractBetweenDelimeters($return['headers'][6], "Location: ", "");
        if ($attachment == 0) {
            return str_replace("attachment=1", "attachment=0", $fileUrl);
        } else {
            return $fileUrl;
        }
    }

    /**
     * Get list of files based on search string
     * results page number and fodler parent id.
     * 
     * @param  string    query to search for
     * @param  integer   page of results to show
     * @param  integer   folder to search, 0 for root
     * 
     */
    function getFiles($query, $page = 1, $parentId = 0) {

        $data = array(
            'oauth_token' => $this->accessToken,
            'query'       => $parentId,
            'page'        => $page
        );
        $url = $this->apiUrl.'files/search/'.rawurlencode(trim($query)).'/page/'.$page;

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';
        $return = $this->controller->http->call($url, $data, "GET", "", $this->contextOptions);
        $tmpRes = json_decode($return['content'], TRUE);
        return $tmpRes['files'];
    }

}

?>