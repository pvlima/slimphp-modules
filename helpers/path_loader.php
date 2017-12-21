<?php

if(!function_exists('load_modules')){

	function load_modules($suffix = '')
	{
		//array com todos os diretórios contidos na pasta /src/Modules
		$paths = glob(__DIR__ . '/../src/Modules/*', GLOB_ONLYDIR);

		if($suffix === '') return $paths;

		foreach ($paths as &$path) {
			$path .= $suffix;
		}

		return $paths;
	}
}

if(!function_exists('load_plugins')){

	function load_plugins($suffix = '')
	{
		//array com todos os diretórios contidos na pasta /plugins
		$paths = glob(__DIR__ . '/../plugins/*', GLOB_ONLYDIR);

		if($suffix === '') return $paths;

		foreach ($paths as &$path) {
			$path .= $suffix;
		}

		return $paths;
	}
}