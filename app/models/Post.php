<?php

class Post extends Phalcon_Model_Base {
	function initialize(){
    	$this->setSource("posts");
  	}
}