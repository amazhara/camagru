<?php

// For debug purpose
//header('Content-Type:text/plain');

// TODO move error reporting setup to another place
// Turn on error messages
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include app
include_once "../app/bootstrap.php";

// Init app
$init = new Router;



// TODO make notifications by email when register
// TODO make notifications when comment photo
// TODO User change password
// TODO User change email
// TODO User change name
// TODO Validate minimum login length
// TODO Validate minimum password length
// TODO Reset password
// TODO User on/off notification via email
