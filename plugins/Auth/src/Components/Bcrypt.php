<?php

namespace Plugins\Auth\Components;

use Exceptions\UnauthorizedException;


class Bcrypt {

	protected static $_saltPrefix = '2a';
	protected static $_defaultCost = 10;
	protected static $_saltLength = 22;

	public static function hash($string, $cost = null) {
		
		if (empty($cost))
			$cost = self::$_defaultCost;

		// Salt
		$salt = self::__generateRandomSalt();

		// Hash string
		$hashString = self::__generateHashString((int)$cost, $salt);

		return crypt($string, $hashString);
	}

	public static function check($string, $hash) {
		if (crypt($string, $hash) === $hash)
			return true;
		else
			throw new UnauthorizedException("Senha Incorreta!");
			
	}

	private static function __generateRandomSalt() {
		// Salt seed
		$seed = uniqid(mt_rand(), true);

		// Generate salt
		$salt = base64_encode($seed);
		$salt = str_replace('+', '.', $salt);

		return substr($salt, 0, self::$_saltLength);
	}

	private static function __generateHashString($cost, $salt) {
		return sprintf('$%s$%02d$%s$', self::$_saltPrefix, $cost, $salt);
	}
}