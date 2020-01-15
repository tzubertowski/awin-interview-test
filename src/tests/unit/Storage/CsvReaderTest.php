<?php

use App\Storage\CsvReader;

class CsvReaderTest extends TestCase
{
    public function testReturnsNoHeadersAndNoDataForEmptyFile()
    {
        $resource = fopen(__DIR__ . '/../../data/empty.csv', 'c+');
        $sut = new CsvReader($resource);
        $this->assertEmpty($sut->headers);
        $this->assertEmpty(iterator_to_array($sut->readLine()));
    }

    public function testReturnsHeadersWhenPresent()
    {
        $resource = fopen(__DIR__ . '/../../data/headersonly.csv', 'c+');
        $sut = new CsvReader($resource);
        $this->assertInstanceOf(CsvReader::class, $sut);
        $this->assertEquals(['head', 'tail'], $sut->headers);
        $this->assertEmpty(iterator_to_array($sut->readLine()));
    }

    public function testReturnsLinesAndHeadersWhenPresent()
    {
        $resource = fopen(__DIR__ . '/../../data/dummy.csv', 'c+');
        $sut = new CsvReader($resource);
        $headers = $sut->headers;
        $data = iterator_to_array($sut->readLine());
        $this->assertEquals(['head', 'tail',], $headers);
        $this->assertEquals(['bar', 'foo',], $data[0]);
    }
}