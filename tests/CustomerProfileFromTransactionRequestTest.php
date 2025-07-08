<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\CreateCustomerProfileFromTransactionRequest;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;
use CommerceGuys\AuthNet\Tests\CreateTransactionRequest\CreateTransactionRequestTestBase;

class CustomerProfileFromTransactionRequestTest extends CreateTransactionRequestTestBase
{
    /**
     * Tests the request with XML format.
     */
    public function testCreateCustomerProfileFromTransactionXml()
    {
        // Create a transaction with customer and billing info (required).
        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_ONLY);
        $transactionRequest->addData('customer', [
            'email' => 'xml_test@example.com',
        ]);
        $transactionRequest->addData('billTo', [
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'address' => '456 Elm St',
            'city' => 'Springfield',
            'state' => 'IL',
            'zip' => '62704',
            'country' => 'US',
            'phoneNumber' => '5555555555',
        ]);

        $transactionResponse = $this->xmlRequestFactory
            ->createTransactionRequest()
            ->setTransactionRequest($transactionRequest)
            ->execute();

        $this->assertEquals('Ok', $transactionResponse->getResultCode());
        $transId = $transactionResponse->transactionResponse->transId ?? null;

        $this->assertNotEmpty($transId, 'Transaction ID should not be empty');

        $request = new CreateCustomerProfileFromTransactionRequest(
            $this->configurationXml,
            $this->client,
            $transId
        );
        /** @var \CommerceGuys\AuthNet\Response\XmlResponse $response */
        $response = $request->execute();
        $contents = $response->contents();

        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());

        $this->assertTrue(property_exists($contents, 'customerProfileId'));
        $this->assertNotEmpty($contents->customerProfileId);

        $this->assertListFieldContainsData($contents, 'customerPaymentProfileIdList');
        $this->assertListFieldContainsData($contents, 'customerShippingAddressIdList');

        $this->assertTrue(property_exists($contents, 'validationDirectResponseList'));
        $this->assertInstanceOf(\stdClass::class, $contents->validationDirectResponseList);
    }

    /**
     * Tests the request with JSON format.
     */
    public function testCreateCustomerProfileFromTransactionJson()
    {
        // Use a new number, otherwise a duplicate transaction is flagged.
        $transactionRequest = $this->createChargableTransactionRequest(
            TransactionRequest::AUTH_ONLY,
            '4007000000027'
        );
        $transactionRequest->addData('customer', [
            'email' => 'json_test@example.com',
        ]);
        $transactionRequest->addData('billTo', [
            'firstName' => 'John',
            'lastName' => 'Smith',
            'address' => '789 Oak St',
            'city' => 'Columbus',
            'state' => 'OH',
            'zip' => '43004',
            'country' => 'US',
            'phoneNumber' => '5555555555',
        ]);
        // Create the transaction.
        $transactionResponse = $this->jsonRequestFactory
            ->createTransactionRequest()
            ->setTransactionRequest($transactionRequest)
            ->execute();

        $this->assertEquals('Ok', $transactionResponse->getResultCode());
        $transId = $transactionResponse->transactionResponse->transId ?? null;

        $this->assertNotEmpty($transId, 'Transaction ID should not be empty');

        // Create the customer profile from the transaction.
        $request = new CreateCustomerProfileFromTransactionRequest(
            $this->configurationJson,
            $this->client,
            $transId
        );
        /** @var \CommerceGuys\AuthNet\Response\JsonResponse $response */
        $response = $request->execute();
        $contents = $response->contents();

        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());

        $this->assertTrue(property_exists($contents, 'customerProfileId'));
        $this->assertNotEmpty($contents->customerProfileId);

        $this->assertIsArray($contents->customerPaymentProfileIdList);
        $this->assertNotEmpty($contents->customerPaymentProfileIdList);

        $this->assertIsArray($contents->customerShippingAddressIdList);
        $this->assertNotEmpty($contents->customerShippingAddressIdList);

        $this->assertIsArray($contents->validationDirectResponseList);
    }

    /**
     * Helper for handling list fields that return stdClass with numericString in XML.
     */
    protected function assertListFieldContainsData($object, string $fieldName): void
    {
        $this->assertTrue(property_exists($object, $fieldName));
        $list = (array) $object->{$fieldName};
        $this->assertArrayHasKey('numericString', $list, "$fieldName must contain numericString key");
        $this->assertNotEmpty($list['numericString'], "$fieldName.numericString must not be empty");
    }
}
