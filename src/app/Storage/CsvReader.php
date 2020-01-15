<?php

namespace App\Storage;

use InvalidArgumentException;
use App\Exceptions\Storage\EndOfResourceException;

class CsvReader
{
    private $csvDatabase;
    public $headers;

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
        while (($csvLine = fgetcsv($this->csvDatabase)) !== false) {
            yield $csvLine;
        }
        throw new EndOfResourceException('There are no more lines to read');
    }
}