<?php

namespace Modules\Accounts;

use \Core\RouterAbstract;

use \Modules\Accounts\Controllers\AccountsController;

class AccountsRoutes extends RouterAbstract
{
	
	public function create()
	{

		$this->_app->group('/accounts', function(){

			$this->get('[/]', AccountsController::class . ':index');
			$this->post('[/]', AccountsController::class . ':add');
			$this->get('/{id}', AccountsController::class . ':view');
			$this->put('/{id}', AccountsController::class . ':edit');
			$this->delete('/{id}', AccountsController::class . ':delete');

		});

		return $this->_app;
		
	}
}
