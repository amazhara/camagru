<?php

// For debug purpose
//header('Content-Type:text/plain');

// Turn on error messages
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include config files
require_once 'config/config.php';
require_once 'config/database.php';

// Include helpers & start session
require_once 'helpers/session_helper.php';
require_once 'helpers/url_helper.php';

// Include core libraries
spl_autoload_register(function($class) {
    require_once 'core/' . $class . '.php';
});
