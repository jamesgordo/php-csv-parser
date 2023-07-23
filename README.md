# PHP CSV Parser

[![Build Status](https://travis-ci.org/jamesgordo/php-csv-parser.svg?branch=master)](https://travis-ci.org/jamesgordo/php-csv-parser) [![codecov](https://codecov.io/gh/jamesgordo/php-csv-parser/branch/master/graph/badge.svg)](https://codecov.io/gh/jamesgordo/php-csv-parser) [![stability-stable](https://img.shields.io/badge/stability-stable-green.svg)](https://github.com/jamesgordo/php-csv-parser)

Turn your CSV files into readable and accessable Data Objects easily. This Library wraps the PHP's built-in
`fgetcsv` function to provide you a hassle free CSV File parsing.

Each row on your CSV file is dynamically transformed into Data Objects with keys set directly from the first
row of your CSV file.

## PHP Version Support

The library has been tested to work on PHP Versions >=5.3.

## How to Use

Run the following command in your terminal

```
composer require jamesgordo/php-csv-parser
```

Or simply add this to your `composer.json`

```json
{
  "require": {
    "jamesgordo/php-csv-parser": "1.0.0"
  }
}
```

Then run

```
composer update
```

Create a Sample CSV File `users.csv`

```csv
id,first_name,last_name
1,John,Doe
2,Eric,Smith
3,Mark,Cooper
```

Example Implementation

```php
<?php
// load vendor autoload
require_once __DIR__ . '/vendor/autoload.php';

use JamesGordo\CSV\Parser;

// Initalize the Parser
$users = new Parser('/path/to/users.csv');

// loop through each user and echo the details
foreach($users->all() as $user) {
	echo "User Details: {$user->id} | {$user->first_name} {$user->last_name}";
}

echo "Total Parsed: " . $users->count() . " Users";

```

## Options

You can set the second as delimiter. The default delimiter is ",".

```php
<?php
// load vendor autoload
require_once __DIR__ . '/vendor/autoload.php';

use JamesGordo\CSV\Parser;

// Initalize the Parser with custom delimiter
$users = new Parser('/path/to/users.csv', "|");
```

You can see the acceptable delimiters [here](https://github.com/jamesgordo/php-csv-parser/blob/master/src/Parser.php#L51)

Below are the list of the public methods you will most likely use.

```php
	$users = new Parser('/path/to/users.csv')	// Initializes the Parser
	$users->setCsv('/path/to/file.csv');		// Sets the File to be Parsed
	$users->getCsv();				// Returns the File to be Parsed
	$users->checkFile('/path/to/file.csv');		// Validates if File is a valid CSV File
	$users->parse();				// Triggers the Parsing of CSV file
	$users->all();					// Returns array of Data Objects parsed from the CSV file
	$users->count();				// Returns the total rows parsed from the CSV file
```

## Version

1.0.4

## License

MIT License

Copyright (c) 2023 James Gordo

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
