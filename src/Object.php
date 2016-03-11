<?php
namespace powerforms\apiclient;


/**
 * Base object for models
 * 
 * @author Powerforms
 *
 */
class Object 
{
	
	
	/**
	 * Allows set all public attributes all at once
	 * 
	 * @param array $attributes
	 */
	public function __construct($attributes)
	{
		foreach($attributes as $name=>$value){
			$this->$name = $value;
		}
		
		$this->init();
	}
	
	/**
	 * Called after construct
	 * 
	 */
	public function init()
	{
		
	}
	
}