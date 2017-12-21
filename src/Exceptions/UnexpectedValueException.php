<?php

namespace Exceptions;

class UnexpectedValueException extends AppException
{
	function __construct($message = "Valor informado é inválido!", $code = 400)
	{
		parent::__construct($message, $code);
	}
}
