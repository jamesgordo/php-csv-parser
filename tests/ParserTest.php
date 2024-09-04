<?php

namespace JamesGordo\CSV\Tests;

use JamesGordo\CSV\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * Testing the Event of parsing a non existing CSV file
     *
     */
    public function testFileNotExist()
    {
        // Set the file to be parsed
        $file = 'employee.csv';

        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage("File $file does not exist");

        // Parse the File
        $users = new Parser($file);
    }

    /**
     * Testing the Event of Parsing CSV with invalid delimiter
     *
     */
    public function testInvalidDelimiter()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Delimiter is not valid.');

        // Set the file to be parsed
        $file = __DIR__ . '/files/users.csv';

        // Parse the File
        $users = new Parser($file, '$');
    }

    /**
     * Testing the Event of Setting empty filename
     *
     * @return void
     */
    public function testSetEmptyFileName()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Filename is not a valid string.');

        // Initialize the Parser
        $users = new Parser();
        $users->setCsv('');
        $users->parse();
    }

    /**
     * Test to verify the event of setting an invalid file type
     *
     */
    public function testInvalidCsvFile()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('File is not a valid csv file.');

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
    public function testParser()
    {
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
    public function testParseCount()
    {
        // Set the file to be parsed
        $csv = __DIR__ . '/files/users.csv';

        // Parse the File
        $users = new Parser($csv);

        // Verify Expected Results
        $this->assertEquals(3, $users->count());
    }

    public function testBlankFirstColumn()
    {
        // Set the file to be parsed
        $csv = __DIR__ . '/files/no-first-column.csv';

        // Parse the File
        $users = new Parser($csv);

        foreach($users->all() as $key => $user) {
            $this->assertEquals(0, strlen($user->id));
        }
    }
}
