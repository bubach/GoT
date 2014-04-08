<?php

/**
 * default.php
 *
 * default application controller
 *
 * @package		JooX 2.0
 * @author		Christoffer Bubach
 */

class Default_Controller extends TinyMVC_Controller {

	function index() {
        // load model
        $this->load->model('Itemlist_Model','items');
        $itemsHtml = $this->items->getItemsHtml(172572910);

        // load content view with sub-views searchbox and pager
        $contentData['listingItems'] = $itemsHtml;
        $contentData['searchBox']    = $this->view->fetch('listing_searchbox_partial');
        $contentData['pager']        = $this->view->fetch('listing_pager_partial');
        $contentOutput = $this->view->fetch('listing_content', $contentData);

        // output main template
        $this->view->assign('title','JooX 2.0');
        $this->view->assign('content', $contentOutput);
		$this->view->display('index_view');
	}

    function view() {
        // parse out fileId from URL
        $this->load->library('uri');
        $fileId = $this->uri->uri_to_assoc(3);
        $fileId = $fileId['view'];

        // load model
        $this->load->model('Item_Model','item');
        $itemData = $this->item->getItemData($fileId, 172572910);
        $itemUrl  = str_replace("attachment=0", "attachment=1", $itemData['fileUrl']);

        // load contentview with sidebar as sub-view
        $contentData['itemSidebar'] = $this->view->fetch('view_sidebar_partial', array('fileUrl'=>$itemUrl));
        $contentData['imageUrl']    = $itemData['imageUrl'];
        $contentData['fileName']    = $itemData['fileName'];
        $contentData['fileUrl']     = $itemData['fileUrl'];

        if (array_key_exists('subtitles', $itemData) && !empty($itemData['subtitles'])) {
            $contentData['subSettings'] = $this->item->getSubtitleSetting($itemData['subtitles']);
        } else {
            $contentData['subSettings'] = "";
        }
        $contentOutput = $this->view->fetch('view_content', $contentData);

        // insert into main design view
        $this->view->assign('title','Stream '.$itemData['fileName']);
        $this->view->assign('content', $contentOutput);
        $this->view->display('index_view');
    }

    function getSubtitle() {
        // parse out fileId from URL
        $this->load->library('uri');
        $fileId     = $this->uri->uri_to_assoc(3);
        $subtitleId = $fileId['getSubtitle'];

        $this->load->library('subtitles');
        header('Content-Type: text/plain; charset=utf-8');
        echo "WEBVTT\n\r\n\r";
        echo $this->subtitles->getSubtitleFile($subtitleId);
    }

    function search() {
        $this->load->library('uri');

        $data['title'] = 'Hello';
        $data['body_text'] = 'Hello world.';
        $this->view->display('hello_view',$data);
    }

}

?>