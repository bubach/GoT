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
		$this->view->display('index_view');
	}

}

?>