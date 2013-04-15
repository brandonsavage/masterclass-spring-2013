<?php

session_start();

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../lib'));
$config = require_once('../config/config.php');
require_once 'MasterController.php';
/*
require_once '../Comment.php';
require_once '../User.php';
require_once '../Story.php';
require_once '../Index.php';*/

$framework = new MasterController($config);
echo $framework->execute();