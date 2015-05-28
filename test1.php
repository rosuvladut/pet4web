<?php

// getup the autoloading
require_once 'vendor/autoload.php';
// getup Propel
require_once 'generated-conf/config.php';

//$users = \pet4web\UsersQuery::create()->find();
$users = \pet4web\UsersQuery::create()->find();
// $authors contains a collection of Author objects
// one object for every row of the author table
foreach($users as $user) {
    echo $user->getName();
}
