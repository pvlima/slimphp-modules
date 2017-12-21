<?php
// DIC configuration

$container = $app->getContainer();

$container['displayErrorDetails'] = function ($c) {
	return $c->get('settings')['displayErrorDetails'];
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Eloquent
$container['db'] = function($c){
	$capsule = new \Illuminate\Database\Capsule\Manager;

	$capsule->addConnection($c->get('settings')['db']);
	$capsule->setAsGlobal();
	$capsule->bootEloquent();

	return $capsule;
};
$container['db'];
