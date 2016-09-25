<?php

namespace CommerceGuys\AuthNet\Tests\Response;

use GuzzleHttp\Psr7\Response;
use CommerceGuys\AuthNet\Response\JsonResponse;

class JsonResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testJsonResponse()
    {
        $payload = '{
    "messages": {
        "resultCode": "Ok",
        "message": [
            {
                "code": "I00001",
                "text": "Successful."
            }
        ]
    }
}';
        $response = new JsonResponse(new Response(200, [], $payload));
        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    }
}