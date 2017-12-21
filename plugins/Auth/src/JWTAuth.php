<?php

namespace Plugins\Auth;

use \Firebase\JWT\JWT;

class JWTAuth
{

	private $secretKey = 'd95e5c493aec017fbe553967245b380d';
	private $algoritm = 'HS256';
	private $expiration = '+12 Hours';


	public function generateToken($context)
	{

		$token = [
			"iss" => "http://spotoyou.com.br", //identifica quem emitiu o jwt
		    // "aud" => "http://example.com", //destinatário jwt, ou seja, pra quem o jwt se destina
		    "iat" => time(), //hora em que o jwt foi emitido
		    "nbf" => time(), //o momento em que o jwt passa a ser aceito
		    "exp" => strtotime($this->expiration),
		    "context" => $context
		];

		$jwt = JWT::encode($token, $this->secretKey, $this->algoritm);
		
		return $jwt;
	}

	public function verifyToken($token)
	{
		// try{
			$decode = JWT::decode($token, $this->secretKey, [$this->algoritm]);
			return $decode;
		// }catch(ExpiredException $e){
			// throw new \Exception("O Token Expirou, galera");
		// }
		
	}
}