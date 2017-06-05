<?php

namespace JamesGordo\CSV;

/**
 * PHP CSV Parser
 *
 * A lightweight wrapper for the PHP CSV Parser providing
 * ease of use in parsing a CSV File. Each row from the
 * CSV will be turned to array of objects for faster and easy 
 * access to each data value.
 *
 * @package  JamesGordo\CSV
 * @author   James Gordo <hello@jamesgordo.com>
 * @version  1.0.0
 */

use JamesGordo\CSV\Data;

class Parser
{
	/**
	 * @var string
	 */
	protected $csv;

	/**
	 * @var array
	 */
	protected $data = array();

	/**
	 * Parser Constructor.
	 *
	 * @return void
	 */
	public function __construct($csv)
	{
		// Set the File to be Parsed
		$this->setCsv($csv);

		// trigger the parsing
		$this->parse();
	}

	/**
	 * Sets the CSV file to be parsed.
	 *
	 * @throws InvalidArgumentException File $file does not exist.
	 * @return void
	 */
	public function setCsv($csv)
	{
		// verify if parameter meets the contract
		if(strlen($csv) < 1) {
			throw new \InvalidArgumentException('Filename is not a valid string.');
		}
		// verify if parameter meets the contract
		if(file_exists($csv) !== true) {
			throw new \InvalidArgumentException("File {$csv} does not exist.");
		}

		$this->csv = $csv;
	}

	/**
	 * Retrieves the file that was
	 * parsed.
	 *
	 * @return $this->csv
	 */
	public function getCsv()
	{
		return $this->csv;
	}

	/**
	 * Parses the CSV file
	 *
	 * @return void
	 */
	private function parse()
	{
		// Open the CSV file
		if (($handle = fopen($this->getCsv(), "r")) !== FALSE) {
			// initialize empty array for the CSV Header
			$keys = array();

			// set the csv index
			$i = 0;

			// loop and assign a the header as the key values the others as the value in its corresponding keys
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				// verify the csv data if not null
				// this is to skip empty lines
				if ($data != null) {
					// verify the starting index
					if ($i == 0) {
						// Set Starting Index as the Data Object Keys
						$keys = $data;
					} else {
						// Initialize the Data Object
						$row = new Data;

						// loop through all csv data
						foreach ($data as $j => $value){
							// Set the Data Property
							$row->{$keys[$j]} = $value;
						}

						// store the csv data as an array
						$this->data[] = $row;
					}

					// increment the index counter
					$i++;
				}
			}

			// close handler
			fclose($handle);
		}
	}

	/**
	 * Retrieves all the CSV Data as array
	 *
	 * @return array JamesGordo\CSV\Data
	 */
	public function all()
	{
		return $this->data;
	}
}