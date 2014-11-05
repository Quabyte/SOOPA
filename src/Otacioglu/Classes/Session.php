<?php

/**
 * This is the Session class.
 *
 * @author  Orçun Otacıoğlu <otacioglu.orcun@gmail.com>
 * @copyright 2014 Orçun Otacıoğlu
 */
class Session
{

	/**
	 * Checks the specified Session value is set.
	 * @param  string $name Session value
	 * @return boolean       
	 */
	public static function exists($name)
	{
		return (isset($_SESSION[$name])) ? true : false;
	}

	/**
	 * Updates a Session value.
	 * @param  string $name  Session value.
	 * @param  string $value New value.
	 * @return string        
	 */
	public static function put($name, $value)
	{
		return $_SESSION[$name] = $value;
	}

	/**
	 * Gets the specified Session value.
	 * @param  string $name Session value.
	 * @return string       
	 */
	public static function get($name)
	{
		return $_SESSION[$name];
	}

	/**
	 * Unsets the specified Session value.
	 * @param  string $name Session value.
	 * @return string       
	 */
	public static function delete($name)
	{

		if(self::exists($name)) {

			unset($_SESSION[$name]);
		}
	}

	/**
	 * Flashes a message to the user.
	 * @param  string $name   Flash message name.
	 * @param  string $string Actual flash message.
	 */
	public static function flash($name, $string = '')
	{
		// If the session value exists splashes a flash message and deletes the session value.
		if(self::exist($name)) {
			
			$session = self::get($name);
			
			self::delete($name);
			
			return $session;

		} else {
			
			self::put($name, $string);
		}

		return '';
	}
}