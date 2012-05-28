<?php

class Comment extends Phalcon_Model_Base {
	function initialize(){
    	$this->setSource("comments");
    	$this->belongsTo("post_id", "Post", "id");
  	}
}