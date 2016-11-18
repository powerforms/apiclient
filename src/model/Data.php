<?php
namespace powerforms\apiclient\model;

use powerforms\apiclient\Object;

/**
 *
 * Data model class
 *	
 * @author Powerforms
 *
 * @property string $id Unique id of state
 * @property array $values Form values
 * @property string $date Date of data creation
 * @property string $state Data state
 * @property integer $form_id Form id
 *
 */
class Data extends Object
{

	public $id;
	public $values;
	public $date;
	public $state;
	public $form_id;

}