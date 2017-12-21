<?php

namespace Modules\Authentication\Services;

use Exceptions\NotFoundException;
use Exceptions\UnexpectedValueException;
use Exceptions\UnauthorizedException;
use Exceptions\BadRequestException;

use Plugins\Auth\JWTAuth;
use Plugins\Auth\Components\Bcrypt;
use Plugins\Validator\Validate as v;

use Modules\Accounts\Repositories\AccountsRepository;

class AuthenticationService
{

	private $accountsRepository;

	function __construct()
	{
		$this->accountsRepository = new AccountsRepository;
	}

	public function login(string $email, string $password)
	{

		$email = v::email($email);

		$account = $this->accountsRepository->findByEmail($email);

		if (Bcrypt::check($password, $account->password)) {

			$jwt = new JWTAuth;
    		$token = $jwt->generateToken($account);

    		$permissions = [
				'account_id'=>1,
				'role'=>'admin',
				'authorities'=>[
					[
						'url'=>'/api/v1/accounts/',
						'view'=>true,
						'add'=>true,
						'edit'=>true,
						'delete'=>true
					],
					[
						'url'=>'/api/v1/accounts/{id}',
						'view'=>true,
						'add'=>true,
						'edit'=>true,
						'delete'=>true
					]
				]
			];

			return [
				'token'=>$token,
				'payload'=>$account,
				'permissions'=>$permissions
			];

		}

	}

}