<?php

namespace CommerceGuys\AuthNet\Tests\Response;

use GuzzleHttp\Psr7\Response;
use CommerceGuys\AuthNet\Response\JsonResponse;
use CommerceGuys\AuthNet\Response\XmlResponse;

class XmlResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testXmlResponse()
    {
        $payload = '<?xml version="1.0" encoding="utf-8"?>
<authenticateTestResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="https://api.authorize.net/xml/v1/schema/AnetApiSchema.xsd">
    <messages>
        <resultCode>Ok</resultCode>
        <message>
            <code>I00001</code>
            <text>Successful.</text>
        </message>
    </messages>
</authenticateTestResponse>';
        $response = new XmlResponse(new Response(200, [], $payload));
        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    }
}