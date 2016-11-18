<?php
namespace powerforms\apiclient;


class ApiException extends \Exception 
{
	
	public function __construct($statusCode)
	{
		parent::__construct('Status code ' . $statusCode);
	}
	
}