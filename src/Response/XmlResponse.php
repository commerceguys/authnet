<?php

namespace CommerceGuys\AuthNet\Response;

use CommerceGuys\AuthNet\Request\XmlRequest;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class XmlResponse extends BaseResponse
{
    public function __construct(HttpResponseInterface $response)
    {
        parent::__construct($response);
        $content = $this->response->getBody()->getContents();
        // The Authorize.net API does not return an absolute URL for XMLNS.
        $xml = @new \SimpleXMLElement($content);
        $json = json_encode((array) $xml);
        $this->contents = json_decode($json);
    }
}
