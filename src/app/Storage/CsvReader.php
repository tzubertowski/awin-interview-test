<?php

namespace App\Storage;

use InvalidArgumentException;

class CsvReader
{
    private $csvDatabase;
    public $headers;
    const delimiter = ';';

    /**
     * @param \Resource $csvDatabase
     * @throws InvalidArgumentException
     */
    public function __construct($csvDatabase)
    {
        // not able to typehint against a resource
        if (!is_resource($csvDatabase)) {
            throw new InvalidArgumentException('CsvReader did not receive a resource to read.');
        }
        $this->csvDatabase = $csvDatabase;
        $this->headers = $this->readLine()->current();
    }

    public function readLine()
    {
        while (($csvLine = fgetcsv($this->csvDatabase, null, self::delimiter)) !== false) {
            yield $csvLine;
        }
    }
}