<?php

use JamesGordo\CSV\Parser;

class ParserTest extends PHPUnit_Framework_TestCase {
	/**
	 * Testing the Event of parsing a non existing
	 * CSV file
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage File employee.csv does not exist.
	 */
	public function testFileNotExist() {
		// Set the file to be parsed
		$file = 'employee.csv';

		// Parse the File
		$users = new Parser($file);
	}

	/**
	 * Testing the Event of Parsing CSV with invalid delimiter
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Delimiter is not valid.
	 */
	public function testInvalidDelimiter() {
		// Set the file to be parsed
		$file = __DIR__ . '/files/users.csv';

		// Parse the File
		$users = new Parser($file, '$');
	}

	/**
	 * Testing the Event of Setting empty filename
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Filename is not a valid string.
	 * @return void
	 */
	public function testSetEmptyFileName() {
		// Initialize the Parser
		$users = new Parser();
		$users->setCsv('');
		$users->parse();
	}

	/**
	 * Test to verify the event of setting
	 * an invalid file type
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage File is not a valid csv file.
	 */
	public function testInvalidCsvFile() {
		// set the invalid file
		$file = __DIR__ . '/DataTest.php';

		// Initialize the Parser
		$users = new Parser($file);
	}

	/**
	 * Test to Verify the CSV Parser
	 *
	 * @return void
	 */
	public function testParser() {
		// Expected Values
		$expected = array(
			array(
				'id' => '1',
				'first_name' => 'John',
				'last_name' => 'Doe'
			),
			array(
				'id' => '2',
				'first_name' => 'Eric',
				'last_name' => 'Smith'
			),
			array(
				'id' => '3',
				'first_name' => 'Mark',
				'last_name' => 'Cooper'
			)
		);

		// Set the file to be parsed
		$csv = __DIR__ . '/files/users.csv';

		// Parse the File
		$users = new Parser($csv);

		// Verify expected users values
		foreach($users->all() as $key => $user) {
			$this->assertEquals($expected[$key]['id'], $user->id);
			$this->assertEquals($expected[$key]['first_name'], $user->first_name);
			$this->assertEquals($expected[$key]['last_name'], $user->last_name);
		}

	}

	/**
	 * Testing the Method to Count the total row Object
	 * parsed from the file
	 *
	 * @return void
	 */
	public function testParseCount() {
		// Set the file to be parsed
		$csv = __DIR__ . '/files/users.csv';

		// Parse the File
		$users = new Parser($csv);

		// Verify Expected Results
		$this->assertEquals(3, $users->count());
	}
}