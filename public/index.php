<?php

date_default_timezone_set('America/Los_Angeles');

set_include_path(
    get_include_path() . 
    PATH_SEPARATOR . realpath('../lib') . 
    PATH_SEPARATOR . realpath('../config')
);

$config = require_once('config.php');
require_once('MasterController.php');

$framework = new MasterController($config);
echo $framework->execute();