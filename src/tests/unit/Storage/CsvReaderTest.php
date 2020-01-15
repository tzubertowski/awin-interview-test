<?php

use App\Exceptions\Storage\EndOfResourceException;
use App\Storage\CsvReader;

class CsvReaderTest extends TestCase
{
    public function testThrowsExceptionWithNoHeader()
    {
        $resource = fopen(__DIR__ . '/../../data/empty.csv', 'c+');
        $this->expectException(EndOfResourceException::class);
        new CsvReader($resource);
    }

    public function testThrowsExceptionWithHeaderButNoData()
    {
        $resource = fopen(__DIR__ . '/../../data/headersonly.csv', 'c+');
        $sut = new CsvReader($resource);
        $this->assertInstanceOf(CsvReader::class, $sut);
        $this->expectException(EndOfResourceException::class);
        iterator_to_array($sut->readLine());
    }

    public function testReadsLines()
    {
        $resource = fopen(__DIR__ . '/../../data/dummy.csv', 'c+');
        $sut = new CsvReader($resource);
        $headers = $sut->headers;
        $data = [];
        try {
            foreach ($sut->readLine() as $csvData) {
                $data[] = $csvData;
            }
        } catch (EndOfResourceException $e) {
            $this->assertEquals(['head', 'tail',], $headers);
            $this->assertEquals([['bar', 'foo',], $data]);
        }
    }
}