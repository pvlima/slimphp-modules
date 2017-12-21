<?php

namespace Plugins\Validator;

use Respect\Validation\Validator as v;

use Exceptions\UnexpectedValueException;

/**
* 
*/
class Validate
{
	
	public static function email(string $email)
	{
		if(v::email()->validate($email)){
			return $email;
		} else {
			throw new UnexpectedValueException("O email informado é inválido");
		}
	}

	public static function validateQueryPaginate(array $queryParams)
	{
		
		$array = [];
		foreach ($queryParams as $k => $v) {
			switch ($k) {

				case 'limit':
					
					if (v::intVal()->validate($v))
						$array['limit'] = (int)$v;
					else
						throw new UnexpectedValueException("a query \"limit\" deve ser um numero inteiro");
					break;

				case 'page':
					
					if (v::intVal()->validate($v))
						$array['page'] = (int)$v;
					else
						throw new UnexpectedValueException("a query \"page\" deve ser um numero inteiro");
					break;

				case 'field':
					if (!empty($v) && is_string($v))
						$array['field'] = $v;
					else
						throw new UnexpectedValueException("a query \"field\" deve ser uma String e não pode ser vazia");
					break;

				case 'sort':
					if(v::contains($v)->validate(['asc', 'desc']))
						$array['sort'] = $v;
					else
						throw new UnexpectedValueException("Para ordenação só são aceitos os valores \"asc\" ou \"desc\" ");
					break;

				case 'search':
					$array['search'] = $v;
					break;
				
				default:
					continue;
					break;
			}
		}

		return $array;

	}

}