<?php
declare(strict_types=1);

namespace Plugins\Acl;

use Plugins\Acl\Entities\Role;
use Plugins\Acl\Entities\Resource;
use Plugins\Acl\Interfaces\UserInterface;

class Acl
{
	
	private $roles;
	private $user;

	function __construct(array $roles, array $resources)
	{
		foreach ($roles as $role) {
			if (!$role instanceof Role)
				throw new \InvalidArgumentException("Invalid Role");
		}

		foreach ($resources as $resource) {
			if (!$resource instanceof Resource)
				throw new \InvalidArgumentException("Invalid Role");
		}

		$this->roles = $roles;
		$this->resources = $resources;
	}

	public function setUser(UserInterface $user): Acl
	{
		$this->user = $user;
		return $this;
	}

	public function hasRole(string $role): bool
	{
		foreach ($this->roles as $r) {
			if ($r->getName() == $role)
				return true;
		}

		return false;
	}

	public function hasPermission(string $role, string $permission): bool
	{

		foreach ($this->roles as $r) {
			if ($r->getName() == $role) {
				foreach ($r->getPermissions() as $p) {
					if ($p->getName() == $permission)
						return true;
				}
			}
		}

		return false;

	}

	public function can(string $permission, UserInterface $user = null): bool
	{

		if ($user)
			return $this->hasPermission($user->getRole(), $permission);

		if ($this->user)
			return $this->hasPermission($this->user->getRole(), $permission);
	
		return false;

	}

	public function cannot(string $permission, UserInterface $user = null): bool
	{

		return !$this->can($permission, $user);

	}

	public function isOwner($resource, UserInterface $user = null): bool
	{

		foreach ($this->resources as $r) {
			if (is_a($resource, $r->getName())) {
				if ($user) {
					return $resource->{$r->getOwnerField()}() == $user->getId();
				}
				return $resource->{$r->getOwnerField()}() == $this->user->getId();
				
			}
		}

		return false;

	}

}