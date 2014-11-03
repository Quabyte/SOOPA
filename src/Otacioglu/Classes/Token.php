<?php

/**
 * This is the Token class.
 *
 * @author  Orçun Otacıoğlu <otacioglu.orcun@gmail.com>
 * @copyright 2014 Orçun Otacıoğlu
 */
class Token
{
	/**
	 * Generates a unique token.
	 * @return string 
	 */
	public stativ function generate()
	{
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}

	/**
	 * Checks whether the generated token matches.
	 * @param  string $token Generated token
	 * @return boolean        
	 */
	public static function check($token)
	{

		$tokenName = Config::get('session/token_name');

		// Session token and generated token is matched or not.
		if(Session::exist($token_name) && $token === Session::get($tokenName)) {

			Session::delete($tokenName);

			return true;
		}

		return false;
	}
}