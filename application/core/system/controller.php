<?php

/**
 * This Controller used to factore commons functions 
 * @author Guitouni Hamza
 * @copyright ilopro.com
 */

class Controller extends API {

	/**
	* $values : array
	* $object : object to map
	* mapps the object's attributs with values
	*/
	public function mapObject($object, $values) {
		
		foreach ($values as $key => $value) {
			$object->{$key}  = $value;
		}
		return $object;
	}

} 

