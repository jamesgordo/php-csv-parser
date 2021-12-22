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
 * @version  1.0.1
 */

class Parser
{
    /**
     * @var string $csv
     */
    protected $csv;

    /**
     * @var array $data
     */
    protected $data = array();

    /**
     * @var array headers
     */
    protected $headers = array();

    /**
     * Setting to 0 makes the maximum line length not limited
     *
     * @var integer $limit
     * @see http://php.net/manual/en/function.fgetcsv.php
     */
    protected $limit = 0;

    /**
     * @var string $delimiter
     */
    protected $delimiter;

    /**
     * @var array valid_delimiters
     */
    protected $valid_delimiters = array( ',', ';', "\t", '|', ':' );

    /**
     * @var array $valid_mime_types
     */
    protected $valid_mime_types = array(
        'text/csv',
        'text/plain',
        'application/csv',
        'text/comma-separated-values',
        'application/excel',
        'application/vnd.ms-excel',
        'application/vnd.msexcel',
    );

    /**
     * Parser Constructor.
     *
     * @param string $csv
     * @param string $delimiter
     * @param int $limit
     * @return void
     */
    public function __construct($csv = null, $delimiter = ",")
    {
        // Parse Automatically if $csv file is passed.
        if (strlen($csv) > 0) {
            // Set the File to be Parsed
            $this->setCsv($csv);

            // Set the Delimeter
            $this->setDelimeter($delimiter);

            // trigger the parsing
            $this->parse();
        }
    }

    /**
     * Sets the CSV file to be parsed.
     *
     * @param string $csv
     * @return void
     */
    public function setCsv($csv)
    {
        // Verify if the CSV File is Valid
        $this->checkFile($csv);

        $this->csv = $csv;
    }

    /**
     * Sets the delimiter for parsing the csv
     *
     * @param $string $delimiter
     * @throws InvalidArgumentException Delimiter is not valid.
     * @return void
     */
    public function setDelimeter($delimiter)
    {
        // verify if parameter meets the contract
        if (in_array($delimiter, $this->valid_delimiters) !== true) {
            throw new \InvalidArgumentException('Delimiter is not valid.');
        }

        $this->delimiter = $delimiter;
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
     * Checks wether the CSV file is Valid.
     *
     * @param string $csv
     * @throws InvalidArgumentException Filename is not a valid string.
     * @throws InvalidArgumentException File $csv does not exist.
     * @throws InvalidArgumentException File is not a valid csv file.
     * @return bool
     */
    public function checkFile($csv = null)
    {
        // set the file to be checked
        $file = ($csv === null) ? $this->getCsv() : $csv;

        // verify if parameter meets the contract
        if (strlen($file) < 1) {
            throw new \InvalidArgumentException('Filename is not a valid string.');
        }

        // verify if parameter meets the contract
        if (file_exists($file) !== true) {
            throw new \InvalidArgumentException("File {$file} does not exist.");
        }

        // verify if file is a valid csv file
        if (!is_object($file) && in_array(mime_content_type($file), $this->valid_mime_types) !== true) {
            throw new \InvalidArgumentException("File is not a valid csv file.");
        }

        return true;
    }

    /**
     * Parses the CSV file
     *
     * @return void
     */
    public function parse()
    {
        // Verify if the CSV File is Valid
        $this->checkFile();

        // Open the CSV file to be parsed
        if (($handle = fopen($this->getCsv(), "r")) !== false) {
            // set the csv index
            $i = 0;

            // loop through each row in the csv file
            while (($data = fgetcsv($handle, $this->limit, $this->delimiter)) !== false) {
                // skip all empty lines
                if ($data[0] != null) {
                    // verify the starting index
                    if ($i !== 0) {
                        // store the row data into the results array
                        $this->data[] = (object) array_combine($this->headers, $data);
                    } else {
                        // Set the CSV Header
                        $this->headers = array_map(array($this,"_sanitize"), $data);
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
     * @return array stdClass
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Returns the total number of rows
     * created into Data Object from the
     * parsed CSV file
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Cleans Up Unwanted Characters
     *
     * @return string
     */
    public function _sanitize($string)
    {
        return preg_replace("/\xEF\xBB\xBF/", "", trim($string));
    }
    
    /**
     * Returns all the headers(columns) of the CSV.
     * 
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }
}
