<?php
declare(strict_types=1);

namespace Plugins\Acl\Interfaces;

interface UserInterface
{
	
	public function getRole(): string;
	public function getId(): int;

}