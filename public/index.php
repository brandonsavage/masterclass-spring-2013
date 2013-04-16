<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../lib'));
require_once('../lib/MasterController.php');

session_start();

$config = require_once('../config/config.php');

$framework = new MasterController($config);
echo $framework->execute();