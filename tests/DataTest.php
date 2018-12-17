<?php

namespace JamesGordo\CSV\Tests;

use JamesGordo\CSV\Data;
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase {
	/**
	 * Testing the event of setting empty key
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Parameter name must be a valid string.
	 * @return void
	 */
	public function testSetEmptyKey() {
		$data = new Data();
		$data->__set('', 'value');
	}

	/**
	 * Testing the Magic Setter and Getter
	 *
	 * @return void
	 */
	public function testMagicSetGet() {
		$data = new Data();
		$property = 'full_name';
		$value = 'John Doe';
		// set the value
		$data->{$property} = $value;

		// Verify the Value
		$this->assertEquals($value, $data->__get($property));
	}
}