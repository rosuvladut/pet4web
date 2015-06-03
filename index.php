<?php

	require "libs/Bootstrap.php";
	require "libs/Controller.php";
	require "libs/View.php";
    require "libs/pdfcrowd.php";
    // getup the autoloading
    require_once 'vendor/autoload.php';
    require_once 'generated-conf/config.php';
    define('FACEBOOK_SDK_V4_SRC_DIR', '/vendor/fb-php-sdk-v4/src/Facebook/');
define('FACEBOOK', '/vendor/fb-php-sdk-v4/src/');
    require 'vendor/facebook-php-sdk-v4/autoload.php';

    define('ROOT_PATH', '../');
    define('URL','http://localhost/pet4web/');
	define('PATH','http://localhost/pet4web/');
	define('SKIN', 'http://localhost/pet4web/public/');
    define('IMG', 'http://localhost/pet4web/public/img/');

	$application = new Bootstrap();
		