<?php
/**
 * Created by PhpStorm.
 * User: reval
 * Date: 13-04-2017
 * Time: 08:17 PM
 */

namespace Reval\Classes\CsvReader;

use League\Csv\Reader;
use Reval\Classes\CsvReader\Validators\RealEstateTransactionValidator;

class CsvReader
{
    /**
     * Instance of CSV read by League/Csv
     *
     * @var Reader
     */
    protected $csv;

    /**
     * All rows from the CSV mapped to the headings from the CSV.
     *
     * @var array
     */
    protected $mappedRows = [];

    /**
     * All error messages for any row.
     *
     * @var array
     */
    protected $validationErrors = [];

    /**
     * CsvReader constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->setCsv(Reader::createFromPath(storage_path('app/' . $filePath)));
    }

    /*
    |--------------------------------------------------------------------------
    | Logic
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Get Headers from the CSV
     *
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->getCsv()->fetchOne();
    }

    /**
     * Get all rows from the CSV not including the row with the headers.
     *
     * @return array
     */
    public function getRowsWithoutHeaders() : array
    {
        return $this->getCsv()->setOffset(1)->fetchAll();
    }

    /**
     * Map all rows in CSV to headings.
     *
     * @return array
     */
    public function mapRows() : array
    {
        $mappedRows = [];
        $lineNumber = 1;

        $headers = $this->getHeaders();

        foreach($this->getRowsWithoutHeaders() as $key => $row) {
            $mappedRows[$lineNumber] = [
                $headers[0] => $row[0],
                $headers[1] => $row[1],
                $headers[2] => $row[2],
                $headers[3] => $row[3],
                $headers[4] => $row[4],
                $headers[5] => $row[5],
                $headers[6] => $row[6],
                $headers[7] => $row[7],
                $headers[8] => $row[8],
                $headers[9] => $row[9],
                $headers[10] => $row[10],
                $headers[11] => $row[11],
                $headers[12] => $row[12],
            ];

            // Transform date.
            if ($mappedRows[$lineNumber]['sale_date']) {
                $mappedRows[$lineNumber]['sale_date'] = strtotime($mappedRows[$lineNumber]['sale_date']);
            }

            $validator = new RealEstateTransactionValidator($mappedRows[$lineNumber], $lineNumber);
            $errors = $validator->validateRow();

            if ($errors) {
                $this->setValidationErrors($errors);
                unset($mappedRows[$lineNumber]);
            }

            $lineNumber++;
        }

        return $mappedRows;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return Reader
     */
    public function getCsv(): Reader
    {
        return $this->csv;
    }

    /**
     * @param Reader $csv
     */
    public function setCsv(Reader $csv)
    {
        $this->csv = $csv;
    }

    /**
     * @return array
     */
    public function getMappedRows(): array
    {
        return $this->mappedRows;
    }

    /**
     * @param array $mappedRows
     */
    public function setMappedRows(array $mappedRows)
    {
        $this->mappedRows = $mappedRows;
    }

    /**
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    /**
     * @param array $validationErrors
     */
    public function setValidationErrors(array $validationErrors)
    {
        $this->validationErrors[$validationErrors['line-number']] = $validationErrors['errors'];
    }
}