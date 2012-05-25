<?php

class IndexController extends Phalcon_Controller {

	function indexAction(){
		$this->view->setVar('posts', Post::find(array("order" => "created DESC", "limit" => 10)));
	}

}