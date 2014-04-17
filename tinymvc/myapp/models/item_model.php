<?php

/**
 * item_model.php
 *
 * model for showing item
 *
 * @package     JooX 2.0
 * @author      Christoffer Bubach
 */

class Item_Model extends TinyMVC_Model {

    private $controller = null;

    function __construct() {
        if ($this->controller == null) {
            $this->controller = tmvc::instance(null, 'controller');

            // load libraries
            $this->controller->load->library('http');
            $this->controller->load->library('putio');
            $this->controller->load->library('subtitles');
        }
    }

    function getItemData($itemId) {
        $data = $this->controller->putio->getFileInfo($itemId);

        $outputData = array(
            'fileName'  => $data['name'],
            'fileId'    => $data['id'],
            'fileSize'  => $data['size'],
            'fileUrl'   => $this->getItemUrl($itemId),
            'imageUrl'  => $data['screenshot'],
            'subtitles' => $this->controller->subtitles->getSubtitleInfo($data['name'])
        );
        return $outputData;
    }

    function getSubtitleSetting($subtitleInfo) {
        $output  = "";
        $counter = 1;

        foreach ($subtitleInfo as $subInfo) {
            if (!empty($output)) {
                $output .= ",\n";
            } else {
                $output .= ", tracks: [";
            }
            $output .= '{ file: "/getSubtitle/'.$subInfo[0].'/'.$subInfo[1].'.vtt", label: "SWE'.$counter.'", kind: "subtitles" }';
            $counter++;
        }

        if (!empty($output)) {
            $output .= "]";
        }
        return $output;
    }

    function getItemUrl($itemId, $attached = 0) {
        return $this->controller->putio->getFileUrl($itemId, $attached);
    }

}

?>