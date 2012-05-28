<?php

class Post extends Phalcon_Model_Base {
	function initialize(){
    	$this->setSource("posts");
    	$this->hasMany("id", "Comment", "post_id");
  	}
}