# PHP-CSV-PARSER

[![Build Status](https://travis-ci.org/jamesgordo/php-csv-parser.svg?branch=master)](https://travis-ci.org/jamesgordo/php-csv-parser)  [![codecov](https://codecov.io/gh/jamesgordo/php-csv-parser/branch/master/graph/badge.svg)](https://codecov.io/gh/jamesgordo/php-csv-parser)

A lightweight wrapper for the PHP CSV Parser providing ease of use in parsing a CSV Files.

The Library returns the CSV file as an array of objects with the first row of the CSV file 
as key properties of the object which gives user easy access to column values.

Installation
===
Add the package to your `composer.json`
```json
{
	"require": {
		"jamesgordo/php-csv-parser": "1.0.0"
	}
}
```
Sample CSV File `users.csv`
```csv
id,first_name,last_name
1,John,Doe
2,Eric,Smith
3,Mark,Cooper
```

Example
```php
<?php

use JamesGordo\CSV\Parser;

public function list_users() {
	// Initalize the Parser
	$users = new Parser('/path/to/users.csv');

	// loop through each user and echo the details
	foreach($users->all() as $user) {
		echo "User Details: {$user->id} | {$user->first_name} {$user->last_name}";
	}
}

```

Version
===
1.0.0

License
===
MIT License

Copyright (c) 2017 James Gordo <hello@jamesgordo.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.