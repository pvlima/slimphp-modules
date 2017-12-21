<?php
$container = $app->getContainer();

// API Auth
$app->group('/api/v1/auth', function(){
	(new \Modules\Authentication\AuthenticationRoutes($this))->create();
});

// API Application
$app->group('/api/v1', function(){

	(new \Modules\Accounts\AccountsRoutes($this))->create();

})
->add(new \Modules\Authentication\Middlewares\AclMiddleware($container))
->add(new \Modules\Authentication\Middlewares\AuthenticationMiddleware($container))
;
