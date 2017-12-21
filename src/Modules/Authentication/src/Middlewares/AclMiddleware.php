<?php
namespace Modules\Authentication\Middlewares;

use Modules\Authentication\Models\AuthorityModel as Authority;
use Modules\Authentication\Models\PermissionsGroupModel as Role;
use Modules\Authentication\Models\PermissionsGroupsAccountModel as RolesAccount;
use Modules\Authentication\Models\PermissionsGroupsAuthorityModel as RolesAuthority;

use Slim\Container;

class AclMiddleware
{

	private $container;

	function __construct(Container $container)
	{
		$this->container = $container;
	}

	function __invoke($request, $response, $next)
	{
		$method = $request->getMethod();
		$route = $request->getAttribute('route')->getPattern();

		$authority = $this->searchAuthority($route, $this->container->permissions['authorities']);

		$permission = $this->checkPermission($method, $authority);

		if ($permission) {
			$response = $next($request, $response);
		} else {
			$response = $response->withStatus(401)->withJson([
				'code'=>401,
				'message'=>'Você não tem permissão para executar esta ação!'
			]);
		}

		
		return $response;

	}

	private function searchAuthority(string $route, array $array)
	{
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				if (in_array($route, $v, true))
					return $v;
			}
		}
		return null;
	}

	private function checkPermission($method, $authority)
	{
		switch ($method) {
			case 'GET':
				if ($authority['view'])
					return true;
				break;

			case 'POST':
				if ($authority['add'])
					return true;
				break;

			case 'PUT':
				if ($authority['edit'])
					return true;
				break;

			case 'DELETE':
				if ($authority['delete'])
					return true;
				break;

		}

		return false;

	}


}
