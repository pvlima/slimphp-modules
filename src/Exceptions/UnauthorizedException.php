<?php

namespace Exceptions;

class UnauthorizedException extends AppException
{
	function __construct($message = "Não Autorizado!", $code = 401)
	{
		parent::__construct($message, $code);
	}
}
