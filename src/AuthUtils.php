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
		return date('Y-m-d\TH:i:s', self::getUTCTime());
	}
	
	private static function getUTCTime()
	{
		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$ret = time();
		date_default_timezone_set($timezone);
	
		return $ret;
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
