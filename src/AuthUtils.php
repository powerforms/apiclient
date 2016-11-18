<?php
namespace powerforms\apiclient;

class AuthUtils 
{
	
	public static function generateSeed($length)
	{
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	private static function getFormatedUTCTime()
	{
		return gmdate('Y-m-d\TH:i:s');
	}
	
	private static function getUTCTime()
	{
		return gmmktime();
	}

	
	private static function prepareToken($date, $seed, $clientSecret)
	{
		$tokenParts = [
			'date'=>$date, 
			'seed'=>$seed
		];
		$tokenParts['hash'] = sha1(implode(';', array_merge($tokenParts,['secret'=>$clientSecret])));
			
		return $tokenParts;
	}
	
	public static function createAuthorizationToken($clientSecret, $seedLength = 16)
	{
		return 
			base64_encode(
				implode(';', 
					self::prepareToken(
						self::getFormatedUTCTime(), 
						self::generateSeed($seedLength), 
						$clientSecret
					)
				)
			);
	}
	
}
