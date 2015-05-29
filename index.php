<?php

	require "libs/Bootstrap.php";
	require "libs/Controller.php";
	require "libs/View.php";
    // getup the autoloading
    require_once 'vendor/autoload.php';
    // getup Propel
    require_once 'generated-conf/config.php';
    //define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');

    define('ROOT_PATH', '../');
    define('URL','http://localhost/pet4web/');
	define('PATH','http://localhost/pet4web/');
	define('SKIN', 'http://localhost/pet4web/public/');
    define('IMG', 'http://localhost/pet4web/public/img/');

	$application = new Bootstrap();
		