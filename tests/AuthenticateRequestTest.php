<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\AuthenticateTestRequest;
use CommerceGuys\AuthNet\DataTypes\MerchantAuthentication;
use CommerceGuys\AuthNet\Tests\TestBase;

/**
 * Tests the AuthenticateTestRequest.
 *
 * This test verifies that the provided merchant credentials are valid
 * using both XML and JSON formats.
 */
class AuthenticateTestRequestTest extends TestBase
{
    /**
     * Tests the authenticateTestRequest using XML format.
     */
    public function testAuthenticateTestXml(): void
    {
        $request = new AuthenticateTestRequest(
            $this->configurationXml,
            $this->client
        );

        // Explicitly set authentication in case configuration does not preload it.
        $request->setMerchantAuthentication(new MerchantAuthentication([
            'name' => $this->configurationXml->getApiLogin(),
            'transactionKey' => $this->configurationXml->getTransactionKey(),
        ]));

        /** @var \CommerceGuys\AuthNet\Response\XmlResponse $response */
        $response = $request->execute();

        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    }

    /**
     * Tests the authenticateTestRequest using JSON format.
     */
    public function testAuthenticateTestJson(): void
    {
        $request = new AuthenticateTestRequest(
            $this->configurationJson,
            $this->client
        );

        $request->setMerchantAuthentication(new MerchantAuthentication([
            'name' => $this->configurationJson->getApiLogin(),
            'transactionKey' => $this->configurationJson->getTransactionKey(),
        ]));

        /** @var \CommerceGuys\AuthNet\Response\JsonResponse $response */
        $response = $request->execute();

        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    }
}
