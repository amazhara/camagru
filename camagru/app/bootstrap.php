<?php

spl_autoload_register(function($class) {
	// change namespace to normal scobes
	// app\core\Class -> app/core/Class
	$path = str_replace('\\', '/', $class . '.php');
	// Include class
	if (file_exists($path)) {
		require $path;
	}
});

$router = new Router;
