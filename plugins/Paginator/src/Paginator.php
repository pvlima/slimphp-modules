<?php

namespace Plugins\Paginator;

use Illuminate\Database\Eloquent\Model;
use Exceptions\UnexpectedValueException;
use Exceptions\NotFoundException;


class Paginator
{

	private $table;

	private $current_page;
	private $limit;
	private $total;
	private $qtd;
	private $last_page;
	
	function __construct(Model $table)
	{
		$this->table = $table;
		$this->current_page = 1;
		$this->limit = 15;
		$this->total = $this->table->count('id');
	}

	public function search($fields, $op, $value, $bool = 'or')
	{
		if (is_array($fields)) {
			foreach ($fields as $v) {
				$this->table = $this->table->where($v, $op, $value, $bool);
			}
			$this->total = $this->table->count('id');
			return $this;
		} else if (is_string($fields)) {
			$this->table = $this->table->where($fields, $op, $value, $bool);
			$this->total = $this->table->count('id');
			return $this;
		} else {
			throw new UnexpectedValueException("O primeiro parametro da função search() deve ser do tipo String ou Array");
		}
	}

	public function limit($limit)
	{
		if ($limit) {
			$this->table = $this->table->limit($limit);
			$this->limit = (int)$limit;
		}

		return $this;
	}

	public function page($page)
	{
		if ($page) {
			$this->table = $this->table->forPage($page, $this->limit);
			$this->current_page = $page;
		}
		
		return $this;
	}

	public function orderBy($field, String $sort = 'asc')
	{
		if($field)
			$this->table = $this->table->orderBy($field, $sort);
		return $this;
	}

	public function exec()
	{
		$this->last_page = ceil($this->total / $this->limit);

		if ($this->total > 0 && $this->current_page > $this->last_page)
			throw new NotFoundException("Página Não Existe!");

		$data = $this->table->get();
		return [
			'current_page' => $this->current_page,
			'last_page' => $this->last_page,
			'limit' => $this->limit,
			'total'=>$this->total,
			'data'=> $data
		];

	}
}
