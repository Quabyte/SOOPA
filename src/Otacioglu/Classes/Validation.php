<?php

/**
 * This is the DB class.
 *
 * @author  Orçun Otacıoğlu <otacioglu.orcun@gmail.com>
 * @copyright 2014 Orçun Otacıoğlu
 */
class Validation
{

	private $_passed = false, // By default validation is not passed.
			$_errors = array(), // Keeps tracks of errors along the Validation.
			$_db = null; // The database we want to Validate on.

	/**
	 * Gets the Database instance
	 */
	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	/**
	 * Prepares the Input values for Validation.
	 * @param  mixed $source  Main Input values.
	 * @param  array  $items  Provided input values by user.
	 * @return boolean        Returns if the given data is Validated or not.
	 */
	public function check($source, $items = array())
	{
		// Loops through provided input values.
		foreach($items as $item => $rules) {

			// Loops through Validation rules.
			foreach($rules as $rule => $rule_value) {

				// Provided data by the user.
				$value = trim($source[$item]);

				// Sanitize the input values.
				$item = escape($item);

				// If the 'required' validation rule is true and the input is empty.
				if($rule === 'required' && empty($value)) {

					// Add an error.
					$this->addError("{$item} is required.");

				} else if(!empty($value)) {

					// If the input is not empty check for Validation rules are matched or not.
					switch ($rule) {

						// Minimum lenght
						case 'min':

							if(strlen($value) < $rule_value) {

								$this->addError("{$item} must be a minimum of {$rule_value} characters.")
							}
							break;

						// Maximum lenght
						case 'max':

							if(strlen($value) > $rule_value) {

								$this->addError("{$item} must be a maximum of {$rule_value} characters.")
							}
							break;

						// Checks if the two input values are matches.	
						case 'matches':

							if($value != $source[$rule_value]) {

								$this->addError("{rule_value} must match {$item}.");
							}
							break;

						// Checks if the input value is already exist on the database.	
						case 'unique':

							$check = $this->_db->get($rule_value, array($item, '=', $value));

							if($check->count()) {

								$this->addError("{item} already exist.");
							}
							break;
					}

				}
			}
		}

		if(empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
	}

	/**
	 * Adds errors to the _errors() array.
	 * @param mixed $error Occured validation errors.
	 */
	private function addError($error)
	{
		$this->_errors[] = $error;
	}

	/**
	 * Errors for public access to show the users.
	 * @return array Validation errors.
	 */
	public function errors()
	{
		return $this->_errors;
	}

	/**
	 * If the validaton passed.
	 * @return boolean 
	 */
	public function passed()
	{
		return $this->_passed;
	}
}