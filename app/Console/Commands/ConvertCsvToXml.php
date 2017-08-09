<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use League\Csv\Statement;
use Reval\Classes\CsvReader\CsvReader;
use Reval\Classes\PhpToXmlConverter\PhpToXmlConverter;
use Reval\Classes\PhpToXmlConverter\Sources\RealEstateTransactionXml;

class ConvertCsvToXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert-csv:to-xml 
                            {filePath : The path to the file you wish to convert}
                            {template : The XML output template you wish to use, existing options are "real-estate-transaction"}
                            {outputPath : The path to where you wish to save your XML file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts supplied CSV to XML format';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Verbose Output.
        if ($this->getOutput()->isVerbose()) {
            $this->info('Starting...');
        }

        // Start timer.
        $timeStart = microtime(true);

        // Get command arguments.
        $filePath = $this->argument('filePath');
        $outputPath = $this->argument('outputPath');

        // Verbose Output.
        if ($this->getOutput()->isVerbose()) {
            $this->info('Reading CSV...');
        }

        // Read CSV.
        $csvReader = new CsvReader($filePath);
        $mappedRows = $csvReader->mapRows();

        // Verbose Output.
        if ($this->getOutput()->isVerbose()) {
            $this->info('Writing XML files...');
        }

        // Initialise progress bar.
        $bar = $this->output->createProgressBar(count($mappedRows));

        // Create XML file for each row.
        foreach($mappedRows as $lineNumber => $mappedRow) {
            // Determine template to use.
            if ($this->argument('template') === 'real-estate-transaction') {
                $xmlTemplate = new RealEstateTransactionXml($mappedRow, $mappedRow['transaction_id'], 'transaction', $outputPath);
            } else {
                // Output error to user if they have not specified the correct template.
                throw new \Exception('The template you specified does not exist');
            }

            // Convert to XML and save row as file.
            $arrayToXmlConverter = new PhpToXmlConverter($xmlTemplate);
            $fileCreated = $arrayToXmlConverter->convertPhpToXml();

            // Verbose Output.
            if ($fileCreated) {
                if ($this->getOutput()->isVerbose()) {
                    $this->info("\nCreated app/xml/transaction_" . $mappedRow['transaction_id'] . ".xml");
                }
            } else {
                $this->error('Something went wrong! Corrupt row:' . $lineNumber);
            }

            $bar->advance();
        }

        $bar->finish();

        $timeEnd = microtime(true);
        $time = $timeEnd - $timeStart;

        // Useful to log time if verbose option is not set.
        \Log::info($time);

        // Verbose Output.
        if ($this->getOutput()->isVerbose()) {
            $this->info("\n Completed in " . $time . " seconds\n");
        }

        // Show errors if any.
        if ($csvReader->getValidationErrors()) {
            $this->error("\n" . count($csvReader->getValidationErrors()) . " Errors \n");
            // Loop through all errors.
            foreach($csvReader->getValidationErrors() as $lineNumber => $error) {
                \Log::info('Line Number ' . $lineNumber . ' has not been saved due to the following errors: ' . $error);
                $this->error('Line Number ' . $lineNumber . ' has not been saved due to the following errors: ' . $error);
            }
        }

    }

}
