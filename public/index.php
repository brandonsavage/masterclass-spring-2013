<?php

set_include_path(get_include_path() . PATH_SEPARATOR .realpath('../lib'));

session_start();

require_once 'MasterController.php';

$config = require_once('../config/config.php');

$framework = new MasterController($config);
echo $framework->execute();

