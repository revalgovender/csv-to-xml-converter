<?php
/**
 * Created by PhpStorm.
 * User: reval
 * Date: 13-04-2017
 * Time: 11:56 PM
 */

namespace Reval\Classes\PhpToXmlConverter;

interface PhpToXmlConverterInterface
{
    public function saveXml();

    public function defineTemplate();
}