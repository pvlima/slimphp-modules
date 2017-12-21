<?php

namespace Middlewares;

class CorsMiddleware
{

	private $options = [
		'allowOrigin' => true,
		'allowMethods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
		'allowHeaders' => true,
		'allowCredentials' => true,
		'exposeHeaders' => '',
		'maxAge' => 86400
	];

	function __construct(array $options = [])
	{
		$this->options = array_merge($this->options, $options);
	}

	function __invoke($request, $response, $next)
	{

		$response = $next($request, $response);

		$response = $response
				->withHeader('Access-Control-Allow-Origin', $this->allowOrigin($request))
				->withHeader('Access-Control-Allow-Credentials', $this->allowCredentials())
				->withHeader('Access-Control-Max-Age', $this->maxAge());

		//Se o método da requisição for OPTIONS, adiciona outros cabeçalhos necessarios ao cors
		if(strtoupper($request->getMethod()) === 'OPTIONS'){
			$response = $response
				->withHeader('Access-Control-Allow-Headers', $this->allowHeaders($request))
				->withHeader('Access-Control-Allow-Methods', $this->allowMethods())
				->withHeader('Access-Control-Expose-Headers', $this->exposeHeaders());
		}

		return $response;

	}

	private function allowOrigin($request)
	{
		$origin = $request->getHeader('Origin');
		if($this->options['allowOrigin'] === true || $this->options['allowOrigin'] === '*'){
			return $origin;
		}

		if(is_array($this->options['allowOrigin'])){
			$origin = (array) $origin;
			foreach ($origin as $o) {
				if(in_array($o, $this->options['allowOrigin'])){
					return $origin;
				}
			}
			return '';
		}

		return (string) $this->options['allowOrigin'];

	}

	private function allowMethods()
	{
		return implode(', ', $this->options['allowMethods']);
	}

	private function allowHeaders($request)
	{
		if($this->options['allowHeaders'] === true){
			return $request->getHeader('Access-Control-Request-Headers');
		}

		return implode(', ', (array) $this->options['allowHeaders']);
	}

	private function allowCredentials()
	{
		return ($this->options['allowCredentials']) ? 'true' : 'false';
	}

	private function exposeHeaders()
	{
		$exposeHeaders = $this->options['exposeHeaders'];

		if (is_string($exposeHeaders) || is_array($exposeHeaders)) {
			return implode(', ', (array) $exposeHeaders);
		}

		return '';
	}

	private function maxAge()
	{
		$maxAge = (String) $this->options['maxAge'];
		return $maxAge ?? '0';
	}


}