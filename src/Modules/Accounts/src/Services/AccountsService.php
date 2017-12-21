<?php

namespace Modules\Accounts\Services;

use Modules\Accounts\Repositories\AccountsRepository;

use Exceptions\BadRequestException;
use Exceptions\NotFoundException;
use Exceptions\UnauthorizedException;
use Exceptions\UnexpectedValueException;

use Plugins\Validator\Validate as v;

class AccountsService
{

	private $accountsRepository;

	function __construct()
	{
		$this->accountsRepository = new AccountsRepository;
	}

	public function getAll()
	{
		return $this->accountsRepository->getAll();
	}

	public function get(int $id)
	{
		return $this->accountsRepository->get($id);
	}

	public function add(array $array)
	{
		foreach ($array as $k => &$v) {
			if ($k == 'email') {
				$v = v::email($v);
			}
		}
		return $this->accountsRepository->add($array);
			
	}

	public function edit(int $id, array $array)
	{
		return $this->accountsRepository->edit($id, $array);
	}

	public function del(int $id)
	{
		return $this->accountsRepository->del($id);
	}

}