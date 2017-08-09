<?php
/**
 * Created by PhpStorm.
 * User: reval
 * Date: 13-04-2017
 * Time: 09:37 PM
 */

namespace Reval\Classes\PhpToXmlConverter;

use SimpleXMLElement;

abstract class AbstractPhpToXmlConverter
{
    /**
     * This should be a multidimensional associative array.
     *
     * @var array
     */
    protected $data;

    /**
     * Simple XML Element instance.
     *
     * @var SimpleXMLElement
     */
    protected $sxe;

    /**
     * Path we want the XML document to be saved to.
     *
     * @var string
     */
    protected $outputPath;

    /**
     * ArrayToXmlConverter constructor.
     *
     * @param array  $data
     * @param string $fileId
     * @param string $parentNode
     * @param string $outputPath
     */
    public function __construct(array $data, string $fileId, string $parentNode, $outputPath = 'xml')
    {
        $this->setData($data);
        $this->setSxe(
            new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><' . $parentNode . '/>')
        );
        $this->setOutputPath(storage_path('app/' . $outputPath . '/transaction_' . $fileId . '.xml'));
    }

    /*
    |--------------------------------------------------------------------------
    | Logic
    |--------------------------------------------------------------------------
    |
    */

    public function saveXml()
    {
        return $this->sxe->asXML($this->getOutputPath());
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
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getSxe(): SimpleXMLElement
    {
        return $this->sxe;
    }

    /**
     * @param SimpleXMLElement $sxe
     */
    public function setSxe(SimpleXMLElement $sxe)
    {
        $this->sxe = $sxe;
    }

    /**
     * @return string
     */
    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    /**
     * @param string $outputPath
     */
    public function setOutputPath(string $outputPath)
    {
        $this->outputPath = $outputPath;
    }

}