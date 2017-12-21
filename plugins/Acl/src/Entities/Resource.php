<?php
declare(strict_types=1);

namespace Plugins\Acl\Entities;

class Resource
{

	private $name;
	private $ownerField;

	function __construct(string $name = null, string $ownerField = null)
	{
		$this->name = $name;
		$this->ownerField = $ownerField;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): Resource
	{
		$this->name = $name;
		return $this;
	}

	public function getOwnerField(): string
	{
		return $this->ownerField;
	}

	public function setOwnerField(string $ownerField): Resource
	{
		$this->ownerField = $ownerField;
		return $this;
	}


}