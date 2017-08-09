<?php
/**
 * Created by PhpStorm.
 * User: reval
 * Date: 14-04-2017
 * Time: 10:20 AM
 */

namespace Reval\Classes\PhpToXmlConverter\Sources;

use Reval\Classes\PhpToXmlConverter\AbstractPhpToXmlConverter;
use Reval\Classes\PhpToXmlConverter\PhpToXmlConverterInterface;

class RealEstateTransactionXml extends AbstractPhpToXmlConverter implements PhpToXmlConverterInterface
{
    /**
     * PhpToXmlConverter constructor.
     *
     * @param array  $data
     * @param string $fileId
     * @param string $parentNode
     * @param string $outputPath
     */
    public function __construct(array $data, string $fileId, string $parentNode, string $outputPath)
    {
        parent::__construct($data, $fileId, $parentNode, $outputPath);
    }

    public function defineTemplate()
    {
        $data = $this->getData();

        // Create XML.
        $this->sxe->addAttribute('id', $data['transaction_id']);

        // Add children.
        $address = $this->sxe->addChild('address');
        $address->addAttribute('format', 'US');
        $address->addChild('street', $data['street']);
        $address->addChild('city', $data['city']);
        $address->addChild('postCode', $data['zip']);
        $address->addChild('state', $data['state']);
        $address->addChild('lat', $data['latitude']);
        $address->addChild('long', $data['longitude']);

        $this->sxe->addChild('beds', '2');

        $this->sxe->addChild('baths', '2');

        $price = $this->sxe->addChild('price');
        $price->addChild('amount', $data['price']);
        $price->addChild('currency', 'USD');

        $this->sxe->addChild('transactionDate', $data['sale_date']);

        $this->sxe->addChild('floorArea', $data['sq__ft']);
    }

}