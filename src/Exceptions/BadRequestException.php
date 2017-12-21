<?php

namespace Exceptions;

class BadRequestException extends AppException
{
	function __construct($message = "Requisição inválida!", $code = 400)
	{
		parent::__construct($message, $code);
	}
}
