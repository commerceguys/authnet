<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\CreateTransactionRequest;

class RequestFactoryTest extends TestBase
{
    public function testRequestFactory()
    {
        $request = $this->xmlRequestFactory->createTransactionRequest();
        $this->assertInstanceOf(CreateTransactionRequest::class, $request);
    }

    public function testInvalidServiceRequest()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Request createNonExistantRequest does not exist"
        );
        $this->xmlRequestFactory->createNonExistantRequest();
    }

    public function testNotInstanceOf()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Request configuration is not a valid request"
        );
        $this->xmlRequestFactory->configuration();
    }
}
