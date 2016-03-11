<?php
/**
 * @link https://github.com/powerforms
 * @copyright Copyright (c) Powerforms
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3) 
 */

namespace powerforms\apiclient;


use GuzzleHttp\Psr7\Uri;
use powerforms\apiclient\model\Form;
use powerforms\apiclient\model\State;
use powerforms\apiclient\model\Data;
/**
 * Client class
 * @author Powerforms
 * @link https://github.com/powerforms
 * 
 */
class Client 
{
	/* @var $guzzleClient GuzzleHttp\Client */
	private $guzzleClient;
	
	private $baseUri;
	
	private $clientId;
	
	private $clientSecret;
	
	/**
	 * Powerforms REST API client
	 * 
	 * @param unknown $baseUri Base URI of REST API
	 * @param unknown $clientId Client ID
	 * @param unknown $clientSecret Client secret
	 */
	public function __construct($baseUri, $clientId, $clientSecret)
	{
		$this->guzzleClient = new \GuzzleHttp\Client();
		$this->baseUri = $baseUri;
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
	}
	
	/** @var string Uri scheme. */
	private $scheme = '';
	
	/** @var string Uri user info. */
	private $userInfo = '';
	
	/** @var string Uri host. */
	private $host = '';
	
	/** @var int|null Uri port. */
	private $port;
	
	/** @var string Uri path. */
	private $path = '';
	
	/** @var string Uri query string. */
	private $query = '';
	
	/** @var string Uri fragment. */
	private $fragment = '';
	
	private function get($endpoint, $query = [])
	{
		
		$options = [
			'headers' => [
				'Authorization' => $this->generateAuthorizationToken(),
				'Accept' => 'application/json',
			],
			'query' => $query,
		];
		
		$res = $this->guzzleClient->get($this->baseUri . '/' . $this->clientId . '/' . $endpoint, $options);
		
		if($res->getStatusCode() != 200){
			throw new ApiException($res->getStatusCode());
		}
		
		
		return $res->json();
	}
	
	private function generateAuthorizationToken()
	{
		return 'Bearer ' . AuthUtils::createAuthorizationToken($this->clientSecret);
	}
	
	/**
	 * Get all available Forms
	 * 
	 * @return array:\powerforms\apiclient\model\Form
	 */
	public function getForms()
	{
		$ret = [];
		foreach($this->get('forms') as $form){
			$object = new Form($form);
			$ret[$object->id] = $object; 
		}
		
		return $ret;	
	}
	
	/**
	 * Get all supported states od data row
	 * 
	 * @return array:\powerforms\apiclient\model\State
	 */
	public function getDataStates()
	{
		$ret = [];
		foreach($this->get('data/states') as $state){
			$object = new State($state);
			$ret[$object->id] = $object;
		}
	
		return $ret;
	}
	
	private function createQuery($ids, $from = false, $to = false, $state = false)
	{
		if(is_array($ids)){
			$ids = implode(',', $ids);
		}
		
		$query = ['ids' => $ids];
		
		if($from !== false){
			$query['from'] = $from;
		}
		
		if($to !== false){
			$query['to'] = $to;
		}
		
		if(is_array($state)){
			$state = implode(',', $state);
		}
		
		if($state !== false){
			$query['state'] = $state;
		}
		
		return $query;
	}
	
	/**
	 * Get data count for specific query
	 * 
	 * @param unknown $ids
	 * @param string $from
	 * @param string $to
	 * @param string $state
	 * @return integer Result count
	 */
	public function getDataCount($ids, $from = false, $to = false, $state = false)
	{
		return $this->get('data/count', $this->createQuery($ids, $from, $to, $state));
	}
	
	/**
	 * Get all data by query (max 1000 rows)
	 * 
	 * @param integer, array of integer $ids form IDs
	 * @param string $from From date
	 * @param string $to To date
	 * @param string $state Only specific states
	 * @return array:\powerforms\apiclient\model\Data
	 */
	public function getData($ids, $from = false, $to = false, $state = false)
	{
		$dataArray = $this->get('data', $this->createQuery($ids, $from, $to, $state));
		
		$ret = [];
		foreach($dataArray as $data){
			$object = new Data($data);
			$ret[$object->id] = $object;
		}
		
		return $ret;
	}
}