<?php

namespace Core;

use Slim\Container;

abstract class ControllerAbstract
{
	/**
	* @var Container
	*/
	protected $_container;
	
	/**
	* @param Container $container
	*/
	function __construct(Container $container)
	{
		$this->_container = $container;
		$this->initialize();
	}

	public abstract function initialize();

	protected function _serialize($value, string $msg = 'Ok')
	{
		$result = [
			'code' => 200,
			'message'=> $msg,
			'result'=> $value
		];

		return $this->_container->response
				->withStatus(200)
				->withJson($result);
	}

	protected function _error(
		String $message = 'Erro Interno!',
		int $code = 500,
		array $detail = null)
	{
		if ($code < 100 || $code > 505) $code = 500;

		$result = [
			'code' => $code,
			'message'=>$message,
			'result' => null
		];

		if (isset($this->_container->displayErrorDetails) && $this->_container->displayErrorDetails)
			$result['details'] = $detail;

		return $this->_container->response
				->withStatus($code)
				->withJson($result);

	}

	public function __call($method, $params)
	{
		switch ($method) {

			/*case 'value':
				break;*/
			
			default:
				throw new NotFoundException("Método $method() não encontrado!");
				break;
		}
	}

}