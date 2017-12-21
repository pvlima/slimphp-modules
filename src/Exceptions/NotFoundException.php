<?php

namespace Exceptions;

class NotFoundException extends AppException
{
	function __construct($message = "Não Encontrado!", $code = 404)
	{
		parent::__construct($message, $code);
	}
}
