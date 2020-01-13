<?php

// TODO moove error reporting to another place
// Turn on error messages

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include app
include_once "../app/bootstrap.php";

// Init app
$init = new Router;
