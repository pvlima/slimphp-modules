<?php

namespace Modules\Accounts\Repositories;

use Modules\Accounts\Models\AccountsModel;

use Exceptions\BadRequestException;
use Exceptions\NotFoundException;
use Exceptions\UnauthorizedException;
use Exceptions\UnexpectedValueException;

class AccountsRepository
{
	
	public function getAll()
	{
		return new AccountsModel;
	}

	public function get(int $id)
	{
		$result = AccountsModel::find($id);
		if ($result)
			return $result;
		else
			throw new NotFoundException("Registro não encontrado!");
	}

	public function add(array $array)
	{
		$insert = new AccountsModel;
		foreach ($array as $k => $v) {
			$insert->$k = $v;
		}
		$add = $insert->save();
		if ($add)
			return $add;
		else
			throw new \Exception("Não foi possível adicionar o registro. Tente novamente", 500);
	}

	public function edit(int $id, array $array)
	{
		$update = $this->get($id);
		foreach ($array as $k => $v) {
			if(empty($v)) continue;
			$update->$k = $v;
		}
		$edit = $update->save();
		if ($edit)
			return $edit;
		else
			throw new \Exception("Não foi possível atualizar o registro. Tente novamente", 500);

	}

	public function del(int $id)
	{
		$del = $this->get($id);
		$del = $del->delete();
		if ($del)
			return $del;
		else
			throw new \Exception("Não foi possível deletar o registro. Tente novamente", 500);
	}

	public function __call($method, $params)
	{

		$findBy = substr($method, 0, 6);
		$field = substr($method, 6, strlen($method));

		if ($findBy == 'findBy'){

			$cols = ['*'];
			if ($params[1]) {

				if (is_array($params[1]))
					$cols = $params[1];
				else
					throw new UnexpectedValueException("O segundo parâmetro do método $method deve ser um array");
			}

			$result = AccountsModel::select($cols)
							->where($field, $params[0])
							->first();

			if ($result)
				return $result;
			else
				throw new NotFoundException("Registro não encontrado!");

		} else
			throw new NotFoundException("Método $method() não encontrado");

	}

}
