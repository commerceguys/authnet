<?php

namespace mglaman\AuthNet\Request;

class XmlRequest extends BaseRequest
{
    /**
     * The XSD for the API.
     *
     * This is not an absolute URL. If passed the absolute URL and error will
     * be thrown as E00045.
     */
    const XSD = 'AnetApi/xml/v1/schema/AnetApiSchema.xsd';

    public function getContentType()
    {
        return 'text/xml';
    }

    public function getBody()
    {
        // The Authorize.net API does not accept an absolute URL for XMLNS.
        $xml = @new \SimpleXMLElement('<' . $this->type . ' xmlns="' . self::XSD . '"/>');
        $this->arrayToXml($this->data, $xml);

        ($xml->asXML('./request.xml'));

        return $xml->asXML();
    }

    public function arrayToXml($array, \SimpleXMLElement $xml)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $this->arrayToXml($value, $xml->addChild("$key"));
                } else {
                    $this->arrayToXml($value, $xml);
                }
            } else {
                $xml->addChild($key, $value);
            }
        }
    }
}
