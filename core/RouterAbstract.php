<?php

namespace Core;

use Slim\App;

abstract class RouterAbstract
{
	/**
	* @var App
	*/
	protected $_app;
	
	/**
	* @param App $app
	*/
	function __construct(App $app)
	{
		$this->_app = $app;
	}

	abstract public function create();
}