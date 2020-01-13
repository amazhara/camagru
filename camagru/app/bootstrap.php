<?php

// TODO add namespaces

// Include core libraries
spl_autoload_register(function($class) {
//    echo 'core/' . $class . '.php' . "\n";
    require_once 'core/' . $class . '.php';
});
