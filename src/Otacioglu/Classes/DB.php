<?php

class DB
{
	/**
	 * Stores the instance of database.
	 * @var array
	 */
	private static $_instance = null;

	private $_pdo,  // Stores the PDO object.  
			$_query, // The last query that is executed.
			$_error = false, // Stores whether there is error or not.
			$_results, // Stores query results.
			$_count = 0; // Stores $_results count.

	private function __construct()
	{
		try {
			/**
			 * Tries to connect to database which is set in Core/Init.php.
			 * @var PDO
			 */
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));

		} catch(PDOException $e) { 
			/**
			 * Cathes the database connection errors and outputs them.
			 */
			die($e->getMessage());
		}
	}

	/**
	 * Creates an instance of the DB connection.
	 * @return array If you haven't get an instance of the DB connection, this function simply calls itself to create a DB connection.
	 */
	public static function getInstance()
	{
		//Prevents connecting to DB more than once.
		if(!isset(self::$_instance)) {
			//Create a DB connection if there is none.
			self::$_instance = new DB();
		}

		return self::$_instance;
	}
}