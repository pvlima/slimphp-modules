<?php
declare(strict_types=1);

namespace Plugins\Acl\Entities;

class Role
{

	private $name;
	private $permissions;

	function __construct(string $name = null)
	{
		$this->name = $name;
		$this->permissions = [];
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): Role
	{
		$this->name = $name;
		return $this;
	}

	public function getPermissions(): array
	{
		return $this->permissions;
	}

	public function addPermission(Permission $permission): Role
	{
		$this->permissions[] = $permission;
		return $this;
	}


}