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
 * @author   James Gordo
 * @version  1.0.0
 */

class Data
{
    /**
     * Automagically sets object properties
     * and make it accessible
     *
     * @throws InvalidArgumentException Parameter name must be a valid string.
     * @return void
     */
    public function __set($name, $value)
    {
        // verify if parameter meets the contract
        if(strlen($name) < 1) {
            throw new \InvalidArgumentException("Parameter name must be a valid string.");
        }

        $this->{$name} = $value;
    }

    /**
     * Retrieves dynamically set
     * object properties
     *
     * @return any
     */
    public function __get($name)
    {
        return $this->{$name};
    }
}
