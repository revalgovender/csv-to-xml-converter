<?php

use Codeception\PHPUnit;
use Reval\Classes\CsvReader\CsvReader as CsvReader;

class CsvReaderTest extends \Codeception\TestCase\Test
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    /**
     * The System Under Test
     *
     * @var CsvReader
     */
    protected $sut;

    protected function _before()
    {
        $this->sut = new CsvReader('csv/real_estate_transactions_sample.csv');
    }

    protected function _after()
    {
    }

    /**
     * Are the correct headers retrieved from the Transaction CSV.
     *
     * @test
     */
    public function doWeSeeTheCorrectHeaders()
    {
        // Assume.
        $headers = [
            "transaction_id",
            "street",
            "city",
            "zip",
            "state",
            "beds",
            "baths",
            "sq__ft",
            "type",
            "sale_date",
            "price",
            "latitude",
            "longitude",
        ];

        // Action.
        $actualHeaders = $this->sut->getHeaders();

        // Assert
        $this->assertEquals($headers, $actualHeaders, 'The headers do not match.');
    }

    /**
     * Are all the rows retrieved from the Transaction CSV.
     *
     * @test
     */
    public function doWeSeeAllRows()
    {
        // Assume.
        $rowCount = 1000;

        // Action.
        $actualRows = $this->sut->getRowsWithoutHeaders();

        // Assert.
        $this->assertCount($rowCount, $actualRows, 'The number of rows do not match.');
    }

    /**
     * Are the correct rows matched up to the correct headers.
     *
     * @test
     */
    public function areTheRowsMappedToTheCorrectHeaders()
    {
        // Assume.
        $mappedRow = [
            "transaction_id" => 'CA7398',
            "street" => '0 Annamark Terrace',
            "city" => 'SACRAMENTO',
            "zip" => '95670',
            "state" => 'CA',
            "beds" => 2,
            "baths" => 2,
            "sq__ft" => 1307,
            "type" => 'Residential',
            "sale_date" => '1444694400',
            "price" => '10491.05',
            "latitude" => '-9.528',
            "longitude" => '124.1693',
        ];

        // Action.
        $mappedRows = $this->sut->mapRows();

        // Assert.
        $this->assertEquals($mappedRow, $mappedRows[1], 'The rows are not mapped correctly.');
    }
}