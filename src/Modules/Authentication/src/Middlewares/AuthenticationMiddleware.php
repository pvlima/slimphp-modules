<?php
namespace Modules\Authentication\Middlewares;

use Plugins\Auth\JWTAuth;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;

use Slim\Container;

class AuthenticationMiddleware
{
	private $container;
	private $permissions;

	function __construct(Container $container)
	{
		$this->container = $container;
		$this->permissions = [
			'account_id'=>1,
			'role'=>'admin',
			'authorities'=>[
				[
					'url'=>'/api/v1/accounts[/]',
					'view'=>true,
					'add'=>false,
					'edit'=>false,
					'delete'=>false
				],
				[
					'url'=>'/api/v1/accounts/{id}',
					'view'=>true,
					'add'=>true,
					'edit'=>true,
					'delete'=>true
				],
				[
					'url'=>'asdfasdf',
					'view'=>true,
					'add'=>true,
					'edit'=>true,
					'delete'=>true
				]
			]
		];
	}

	function __invoke($request, $response, $next)
	{

		$token = $request->getHeaderLine('Authorization');
		$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zcG90b3lvdS5jb20uYnIiLCJpYXQiOjE1MTM4NjA5MDYsIm5iZiI6MTUxMzg2MDkwNiwiZXhwIjoxNTEzOTA0MTA2LCJjb250ZXh0Ijp7ImlkIjoxMSwibmFtZSI6IkJyZW5vIENhbm5hYmlzIiwiZW1haWwiOiJicmVub0BjYW5uYWJpcy5jb20iLCJ0eXBlIjoyLCJjb3VudHJ5X2NvZGUiOiIrNTUiLCJwaG9uZSI6Iig4OCkgNCAyMDQyLTA0MjAiLCJwaG9uZV92YWxpZCI6MCwiZW1haWxfdmFsaWQiOjAsInN0YXR1cyI6MSwidXBkYXRlZF9hdCI6IjIwMTctMTItMjAgMTk6MzY6MTMiLCJjcmVhdGVkX2F0IjoiMjAxNy0xMi0xNSAxOTowODoxMSJ9fQ.M4VxCtinUK6lcObcI26wJG2o4xXSq-PnzlsRS2r3Eag';

		if (isset($token) && !empty($token)) {
			
			$result['code'] = 401;
			$jwt = new JWTAuth;

			try {

				$payload = $jwt->verifyToken($token);

				$this->container['payload'] = $payload;
				$this->container['permissions'] = $this->permissions;

				$response = $next($request, $response);

			} catch (ExpiredException $e) {
				$result['message'] = 'O token expirou!';
				return $response = $response->withStatus($result['code'])->withJson($result);
			} catch (BeforeValidException $e) {
				$result['message'] = 'O token não pode ser usado neste momento!';
				return $response = $response->withStatus($result['code'])->withJson($result);
			} catch (SignatureInvalidException $e) {
				$result['message'] = 'Falha na verificação de assinatura do token!';
				return $response = $response->withStatus($result['code'])->withJson($result);
			} catch (\UnexpectedValueException $e) {
				$result['message'] = 'Houve um erro no token. Utilize um token diferente.';
				// $result['detail'] = [$e->getMessage(),$e->getFile().':('.$e->getLine().')'];
				return $response = $response->withStatus($result['code'])->withJson($result);
			} catch (\Exception $e) {
				$result['message'] = $e->getMessage();
				$result['detail'] = $e->getTrace();
				return $response = $response->withStatus($result['code'])->withJson($result);
			}

		} else {
			$result['code'] = 403;
			$result['message'] = 'Acesso Proibido!';
			$response = $response->withStatus($result['code'])->withJson($result);
		}

		return $response;

	}

/*	private function getAuthorities()
	{
		use Modules\Authentication\Models\AuthorityModel as Authority;
		use Modules\Authentication\Models\PermissionsGroupModel as Role;
		use Modules\Authentication\Models\PermissionsGroupsAccountModel as RolesAccount;
		use Modules\Authentication\Models\PermissionsGroupsAuthorityModel as RolesAuthority;



	}*/


}
