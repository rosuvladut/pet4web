<?php

// setup the autoloading
require_once 'vendor/autoload.php';
// setup Propel
require_once 'generated-conf/config.php';

$user=new \pet4web\Users();
$user->setName('George');
$user->setEmail('george@test.com');
$user->setType('user');
$user->setBirth(time());
$user->setCountry('Romania');
//$user->setPetId(1);
$user->save();
