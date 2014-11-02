<?php

/**
 * This is the Inputclass.
 *
 * @author  Orçun Otacıoğlu <otacioglu.orcun@gmail.com>
 * @copyright 2014 Orçun Otacıoğlu
 */
class Input 
{

	/**
	 * Checks if the input is a valid HTTP request.
	 * @param  string $type default request is POST.
	 * @return boolean       HTTP Request
	 */
	public static function exist($type = 'post')
	{
		switch ($type) {
			// If it is POST.
			case 'post':
				// Returns true
				return (!empty($_POST)) ? true : false;
				break;
			case 'get':
				// If it is GET
				return (!empty($_GET)) ? true : false;
				break;

			default:
				// It must return false by default. Because if there is no HTTP request there should be an error.
				return false;
				break;
		}
	}

	/**
	 * Gets the input values
	 * @param  mixed $item Form values.
	 * @return mixed       Returns the input values.
	 */
	public static function get($item)
	{
		// If the form method is POST
		if(isset($_POST[$item])) {

			return $_POST[$item];

		} else if(isset($_GET[$item])) {
			// If the form method is GET
			return $_GET[$item];
		}
		// If the form method is not set this will returns an empty string.
		return '';
	}
}