<?php

// Aplicar Cors Headers nas requisições
$app->add(new \Middlewares\CorsMiddleware([
	'allowOrigin' => true,
	'allowMethods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
	'allowHeaders' => true,
	'allowCredentials' => true,
	'maxAge' => 86400
]));
