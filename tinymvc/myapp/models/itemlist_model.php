<?php

/**
 * itemlist_model.php
 *
 * model for listing items
 *
 * @package     JooX 2.0
 * @author      Christoffer Bubach
 */

class Itemlist_Model extends TinyMVC_Model {

    function getItemsHtml($parent = 0) {
        $controller = tmvc::instance(null,'controller');

        // try to load libraries
        try {
            $controller->load->library('http');
            $controller->load->library('putio');
        } catch (Exception $e) {
            return "";
        }

        //$data       = $controller->putio->getFileList($parent);
        $data       = $controller->putio->getFiles("Game of thrones", $page = 1, $parent);
        $outputHtml = "";

        foreach ($data as $item) {
            if ($item['content_type'] == "video/mp4") {
                $tmpData['itemLinkUrl']  = '/view/'.$item['id'];
                $tmpData['itemImageUrl'] = $item['screenshot'];
                $tmpData['itemName']     = $item['name'];

                $outputHtml .= $controller->view->fetch('listing_item_partial', $tmpData);
            }
        }
        return $outputHtml;
    }

}

?>