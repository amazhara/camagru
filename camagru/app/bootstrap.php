<?php

// TODO add namespaces

// Include config files
require_once 'config/config.php';
require_once 'config/database.php';

// Include core libraries
spl_autoload_register(function($class) {
    require_once 'core/' . $class . '.php';
});
