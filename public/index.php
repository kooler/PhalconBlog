<?php

try {
	$front = Phalcon_Controller_Front::getInstance();

	//Setting directories
	$front->setControllersDir("../app/controllers/");
	$front->setModelsDir("../app/models/");
	$front->setViewsDir("../app/views/");

	//Printing view output
	echo $front->dispatchLoop()->getContent();
} catch(Phalcon_Exception $e) {
	echo "PhalconException: ", $e->getMessage();
}