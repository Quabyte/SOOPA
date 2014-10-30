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

	/**
	 * Secure querying to avoid SQL injections
	 * @param  string $sql    DB name.
	 * @param  array  $params Parameters for query.
	 * @return object         
	 */
	public function query($sql, $params = array())
	{
		// Resets the errors array.
		$this->_error = false;
		
		// Checks if the DB is ready for query.
		if($this->_query = $this->_pdo->prepare($sql)) {
			
			// Checks if there is more than one parameters to attach to the query.
			if(count($params)) {
				
				// Binds the parameter values to the query.
				foreach($params as $param) {
					$this->_query->bindValue(pos, $param);
				}
			}

			// If the query successfully executed.
			if($this->_query->execute()) {

				/**
				 * Fetches the returned values from query.
				 * @var Object
				 */
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);

				/**
				 * Stores the amount of rows that is returned.
				 * @var integer
				 */
				$this->_count = $this->_query->rowCount();
			} else {

				// Sets the errors if the query fails.
				$this->_error = true;
			}
		}

		// Returns the object after the query.
		return $this;
	}

	/**
	 * Method to perform the query
	 * @param  $action Choose to action to perform with the given table.
	 * @param  string $table  Table name that wanted to perform query.
	 * @param  array  $where  Table column and operators.
	 * @return object         Returns the queried object.
	 */
	public function action($action, $table, $where = array())
	{
		// There must be 3 values in the $where array to perform a query.
		if(count($where) === 3) {

			// Allowed operatorsfor performing a query
			$operators = array('=', '>', '<', '>=', '<=');

			// Table column name.
			$field    = $where[0];

			// Query operator.
			$operator = $where[1];

			// Query parameter.
			$value    = $where[2];

			// If the given operator is in allowed operator types
			if(in_array($operator, $operators)) {

				// Set the actual SQL query.
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

				// If there is no error return the object.
				if(!$this->query($sql, array($value))->error()) {

					return $this;
				}
			}
		}

		// If there is an error occured return false.
		return false;
	}

	/**
	 * Selecting objects from a table using the action( method)
	 * @param  string $table Table name.
	 * @param  array  $where Table column and operators performing a query.
	 * @return object  
	 */
	public function get($table, $where) 
	{
		// Returns the selected objects.
		return $this->action('SELECT *', $table, $where);
	}

	/**
	 * Deleting objects from a table using the action() method.
	 * @param  string $table Table name.
	 * @param  array  $where Table column and operators performing a query.
	 * @return object        
	 */
	public function delete($table, $where)
	{
		// Deletes the selected objects.
		return $this->action('DELETE', $table, $where);
	}

	/**
	 * Returns the query errors.
	 * @return array Query errors
	 */
	public function error()
	{
		return $this->_error;
	} 

	/**
	 * Returns the amount of objects that are returned.
	 * @return integer 
	 */
	public function count()
	{
		return $this->_count;
	}
}