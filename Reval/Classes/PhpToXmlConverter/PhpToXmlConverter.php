<?php
/**
 * Created by PhpStorm.
 * User: reval
 * Date: 14-04-2017
 * Time: 10:47 AM
 */

namespace Reval\Classes\PhpToXmlConverter;


class PhpToXmlConverter
{
    /**
     * Instance of PhpToXmlConverterInterface.
     *
     * @var PhpToXmlConverterInterface
     */
    protected $phpToXmlConverter;

    /**
     * PhpToXmlConverter constructor.
     *
     * @param PhpToXmlConverterInterface $phpToXmlConverter
     */
    public function __construct(PhpToXmlConverterInterface $phpToXmlConverter)
    {
        $this->setPhpToXmlConverter($phpToXmlConverter);
    }

    /*
    |--------------------------------------------------------------------------
    | Logic
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Convert Php to XML format.
     *  - Sets the XML template to be used based on PhpToXmlConverterInterface instance.
     *  - Saves the XML file to output folder (eg: storage/app/xml/transaction_id.xml).
     *
     * @return bool
     */
    public function convertPhpToXml() : bool
    {
        $this->getPhpToXmlConverter()->defineTemplate();

        return $this->getPhpToXmlConverter()->saveXml();
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @return PhpToXmlConverterInterface
     */
    public function getPhpToXmlConverter(): PhpToXmlConverterInterface
    {
        return $this->phpToXmlConverter;
    }

    /**
     * @param PhpToXmlConverterInterface $phpToXmlConverter
     */
    public function setPhpToXmlConverter(PhpToXmlConverterInterface $phpToXmlConverter)
    {
        $this->phpToXmlConverter = $phpToXmlConverter;
    }


}