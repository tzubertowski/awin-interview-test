<?php

use App\Storage\CsvReader;
use App\Transactions\Entity\TransactionHydrator;
use App\Transactions\TransactionRepository;

class TransactionRepositoryTest extends TestCase
{
    public function testReturnsEmptyForNoData()
    {
        $csvReader = \Mockery::mock(CsvReader::class);
        $csvReader->shouldReceive('readLine')->andReturn(new EmptyIterator());
        $sut = new TransactionRepository($csvReader);
        $transactions = $sut->getTransactionsByMerchantId(1);
        $this->assertIsArray($transactions);
        $this->assertEmpty($transactions);
    }

    public function testReturnsEmptyForNoTransactionsForMerchant()
    {
        $iterator = new ArrayIterator([[2,"01/05/2010", "£50.00"],]);
        $csvReader = \Mockery::mock(CsvReader::class);
        $csvReader->shouldReceive('readLine')->andReturn($iterator);
        $sut = new TransactionRepository($csvReader);
        $transactions = $sut->getTransactionsByMerchantId(1);
        $this->assertIsArray($transactions);
        $this->assertEmpty($transactions);
    }

    public function testReturnsMerchantTransactions()
    {
        $transactionData = [2,"01/05/2010", "£50.00"];
        $iterator = new ArrayIterator([$transactionData,]);
        $csvReader = \Mockery::mock(CsvReader::class);
        $csvReader->shouldReceive('readLine')->andReturn($iterator);
        $sut = new TransactionRepository($csvReader);
        $transactions = $sut->getTransactionsByMerchantId(2);
        $this->assertIsArray($transactions);
        $this->assertEquals(
            reset($transactions),
            TransactionHydrator::fromArray([2,"01/05/2010", "£50.00"])
        );
    }
}