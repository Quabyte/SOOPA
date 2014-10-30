<?php

class Config
{
	public static function get($path = null)
	{
		
		/**
		 * Checks if the path is set.
		 */
		if($path) {
			
			/**
			 * If the path is set, we need to reach to Config array to retrieve data.
			 * @var array
			 */
			$config = $GLOBALS['config'];
			
			/**
			 * Returns the first index from the given $path variable.
			 * @var array
			 */
			$path = explode('/', $path);

			/**
			 * Loops through the Config array indexes.
			 */
			foreach($path as $index) {

				/**
				 * Checks if the array index is set.
				 */
				if(isset($config[$index])) {

					/**
					 * To retrieve the second or third level indexes we set the $config variable to the returned value.
					 * @var array
					 */
					$config = $config[$index];
				}
			}

			/**
			 * Returns the desired config value.
			 */
			return $config;
		}

		/**
		 * If the $path is not set return false.
		 */
		return false;
	}
}