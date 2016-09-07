<?php

namespace mglaman\AuthNet\Tests;

use mglaman\AuthNet\CreateTransactionRequest;

class RequestFactoryTest extends TestBase
{
    public function testRequestFactory()
    {
        $request = $this->requestFactory->createTransactionRequest();
        $this->assertInstanceOf(CreateTransactionRequest::class, $request);
    }

    public function testInvalidServiceRequest()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Request createNonExistantRequest does not exist"
        );
        $this->requestFactory->createNonExistantRequest();
    }

    public function testNotInstanceOf()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Request configuration is not a valid request"
        );
        $this->requestFactory->configuration();
    }
}
