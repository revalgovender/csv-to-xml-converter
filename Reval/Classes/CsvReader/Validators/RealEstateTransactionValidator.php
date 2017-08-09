<?php
/**
 * Created by PhpStorm.
 * User: reval
 * Date: 14-04-2017
 * Time: 05:11 PM
 */

namespace Reval\Classes\CsvReader\Validators;

use Illuminate\Support\Facades\Validator;

class RealEstateTransactionValidator
{
    /**
     * Rules to validate each row in CSV.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Data to validate.
     *
     * @var array
     */
    protected $mappedRow = [];

    /**
     * Line number container invalid row.
     *
     * @var int
     */
    protected $lineNumber;

    /*
    |--------------------------------------------------------------------------
    | Logic
    |--------------------------------------------------------------------------
    |
    */

    /**
     * RealEstateTransactionValidator constructor.
     *
     * @param array  $mappedRow
     * @param int    $lineNumber
     */
    public function __construct(array $mappedRow, int $lineNumber)
    {
        $this->setMappedRow($mappedRow);
        $this->setLineNumber($lineNumber);
    }

    public function validateRow()
    {
        $this->setRules([
            'transaction_id' => 'required',
            'street' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required',
            'state' => 'required|us_state_code',
            'beds' => 'required|integer|min:0',
            'baths' => 'required|integer|min:0',
            'sq__ft' => 'required|numeric|min:0',
            'type' => 'required',
            'sale_date' => 'required',
            'price' => 'numeric|min:0',
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
        ]);

        $validator = Validator::make($this->getMappedRow(), $this->getRules());

        if ($validator->fails()) {
            return [
                'line-number' => $this->getLineNumber(),
                'errors' => $validator->errors()
            ];
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return array
     */
    public function getMappedRow(): array
    {
        return $this->mappedRow;
    }

    /**
     * @param array $mappedRow
     */
    public function setMappedRow(array $mappedRow)
    {
        $this->mappedRow = $mappedRow;
    }

    /**
     * @return int
     */
    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     */
    public function setLineNumber(int $lineNumber)
    {
        $this->lineNumber = $lineNumber;
    }
}