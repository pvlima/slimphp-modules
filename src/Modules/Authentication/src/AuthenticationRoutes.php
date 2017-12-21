<?php

namespace Modules\Authentication;

use \Core\RouterAbstract;

use \Modules\Authentication\Controllers\AuthenticationController;

class AuthenticationRoutes extends RouterAbstract
{
	
	public function create()
	{

		// $this->_app->group('/auth', function(){

			$this->_app->post('/login[/]', AuthenticationController::class . ':login');

		// });

		return $this->_app;
		
	}
}
