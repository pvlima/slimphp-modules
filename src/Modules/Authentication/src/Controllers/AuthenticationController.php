<?php

namespace Modules\Authentication\Controllers;

use Core\ControllerAbstract;

use Slim\Http\Request;
use Slim\Http\Response;

use Exceptions\NotFoundException;
use Exceptions\UnexpectedValueException;
use Exceptions\UnauthorizedException;
use Exceptions\BadRequestException;

use Modules\Authentication\Services\AuthenticationService;


class AuthenticationController extends ControllerAbstract
{

	private $authService;

	public function initialize()
	{
		$this->authService = new AuthenticationService;
	}

	public function login(Request $request)
	{
		$email = $request->getParsedBodyParam('email');
		$password = $request->getParsedBodyParam('password');

		try {

			$login = $this->authService->login($email, $password);

			return $this->_serialize($login, 'Login Efetuado com sucesso!');
			
		} catch (UnexpectedValueException $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (NotFoundException $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (UnauthorizedException $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		} catch (\Exception $e) {
			return $this->_error($e->getMessage(), $e->getCode(), $e->getTrace());
		}

	}

}
