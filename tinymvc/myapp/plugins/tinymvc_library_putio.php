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


    function getFileList($parentId = 0) {

        $data = array(
            'oauth_token' => $this->accessToken,
            'parent_id'   => $parentId
        );
        $controller = tmvc::instance(null,'controller');
        $url        = $this->apiUrl.'files/list';

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';

        $return = $controller->httpcall->httpCall($url, $data, "GET", "", $this->contextOptions);
        $tmpRes = json_decode($return['content'], TRUE);
        return $tmpRes['files'];
    }

    function getFileInfo($fileId) {

        $data       = array('oauth_token' => $this->accessToken);
        $controller = tmvc::instance(null,'controller');
        $url        = $this->apiUrl.'files/'.$fileId;

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';
        $return = $controller->httpcall->httpCall($url, $data, "GET", "", $this->contextOptions);
        $tmpRes = json_decode($return['content'], TRUE);
        return $tmpRes['file'];
    }

    function getFileUrl($fileId, $attachment = 0) {

        $data       = array('oauth_token' => $this->accessToken);
        $controller = tmvc::instance(null,'controller');
        $url        = $this->apiUrl.'files/'.$fileId.'/download';

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';
        $return  = $controller->httpcall->httpCall($url, $data, "GET", "", $this->contextOptions);
        $fileUrl = $controller->httpcall->extractBetweenDelimeters($return['headers'][6], "Location: ", "");
        if ($attachment == 0) {
            return str_replace("attachment=1", "attachment=0", $fileUrl);
        } else {
            return $fileUrl;
        }
    }

    function getFiles($query, $page = 1, $parentId = 0) {

        $data = array(
            'oauth_token' => $this->accessToken,
            'query'       => $parentId,
            'page'        => $page
        );

        $controller = tmvc::instance(null,'controller');
        $url        = $this->apiUrl.'files/search/'.rawurlencode(trim($query)).'/page/'.$page;

        $this->contextOptions['ssl']['cafile'] = __DIR__ . '/Certificates/StarfieldSecureCertificationAuthority.crt';
        $return = $controller->httpcall->httpCall($url, $data, "GET", "", $this->contextOptions);
        $tmpRes = json_decode($return['content'], TRUE);
        return $tmpRes['files'];
    }

}

?>