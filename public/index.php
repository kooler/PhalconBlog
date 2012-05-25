<?php

try {
	$front = Phalcon_Controller_Front::getInstance();

	//Setting up framework config
	$config = new Phalcon_Config(array(
		"database" => array(
		"adapter" => "Mysql",
		"host" => "localhost",
		"username" => "root",
		"password" => "",
		"name" => "phalcon"
	),
	"phalcon" => array(
		"controllersDir" => "../app/controllers/",
		"modelsDir" => "../app/models/",
		"viewsDir" => "../app/views/"
	)
	));
	$front->setConfig($config);

	//Printing view output
	echo $front->dispatchLoop()->getContent();
} catch(Phalcon_Exception $e) {
	echo "PhalconException: ", $e->getMessage();
}