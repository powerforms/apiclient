<?php
namespace powerforms\apiclient\model;

use powerforms\apiclient\Object;

/**
 * Form model class
 *
 * @author Powerforms
 *
 * @property integer $id Unique id of form (used for this api)
 * @property string $uuid Unique UUID of form (used in frontend)
 * @property string $name Name of form
 *
 */
class Form extends Object
{

	public $id;
	public $uuid;
	public $name;

}