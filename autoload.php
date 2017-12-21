<?php

$composer = require __DIR__ . '/vendor/autoload.php';

/**
* Registra autoload de todos os módulos
*/
$modules = load_modules('/src');
foreach ($modules as &$module) {
	$namespaceModule = explode('/', $module);
	$namespaceModule = $namespaceModule[count($namespaceModule) - 2];

	$composer->setPsr4('Modules\\'.$namespaceModule.'\\', $module);
}

/**
* Registra autoload de todos os plugins
*/
$plugins = load_plugins('/src');
foreach ($plugins as &$plugin) {
	$namespacePlugin = explode('/', $plugin);
	$namespacePlugin = $namespacePlugin[count($namespacePlugin) - 2];

	$composer->setPsr4('Plugins\\'.$namespacePlugin.'\\', $plugin);
}

/**
* Registro de outros namespaces
*/

// Core
$composer->setPsr4('Core\\', __DIR__ . '/core');

// Middlewares
$composer->setPsr4('Middlewares\\', __DIR__ . '/src/Middlewares');

// Exceptions
$composer->setPsr4('Exceptions\\', __DIR__ . '/src/Exceptions');

return $composer;