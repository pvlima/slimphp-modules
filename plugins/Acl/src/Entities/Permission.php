<?php
declare(strict_types=1);

namespace Plugins\Acl\Entities;

class Permission
{

	private $name;

	function __construct(string $name = null)
	{
		$this->name = $name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): Permission
	{
		$this->name = $name;
		return $this;
	}


}