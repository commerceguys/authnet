<?php

namespace mglaman\AuthNet\Tests;

use GuzzleHttp\Client;
use mglaman\AuthNet\Configuration;
use mglaman\AuthNet\CreateTransactionRequest;
use mglaman\AuthNet\DataTypes\CreditCard;
use mglaman\AuthNet\DataTypes\Order;
use mglaman\AuthNet\DataTypes\TransactionRequest;

class CreateTransactionRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \mglaman\AuthNet\Configuration
     */
    protected $configuration;
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->configuration = new Configuration([
          'api_login' => AUTHORIZENET_API_LOGIN_ID,
          'transaction_key' => AUTHORIZENET_TRANSACTION_KEY,
          'sandbox' => true,
        ]);
        $this->client = new Client();
    }

    public function testAuthCaptureTransaction()
    {
        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);

        // XML
        $request = new CreateTransactionRequest($this->configuration, $this->client, $transactionRequest);
        $response = $request->execute();
        $this->assertTrue(isset($response->transactionResponse));
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
        $this->assertEquals('Ok', $response->getResultCode());
        // @todo Test JSON, it's not working.
    }

    public function testAuthTransaction()
    {
        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_ONLY);

        // XML
        $request = new CreateTransactionRequest($this->configuration, $this->client, $transactionRequest);
        $response = $request->execute();
        $this->assertTrue(isset($response->transactionResponse));
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
        $this->assertEquals('Ok', $response->getResultCode());
        // @todo Test JSON, it's not working.
    }

    public function testPriorAuthCaptureTransaction()
    {
        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_ONLY);

        // XML
        $request = new CreateTransactionRequest($this->configuration, $this->client, $transactionRequest);
        $response = $request->execute();

        // This randomly fails. Maybe because we try to capture too soon?
        // Try sleeping for a little bit.
        sleep(2);

        // XML
        $request = new CreateTransactionRequest($this->configuration, $this->client);
        $request->setTransactionRequest(new TransactionRequest([
          'transactionType' => TransactionRequest::PRIOR_AUTH_CAPTURE,
          'amount' => 5.00,
          'refTransId' => $response->transactionResponse->transId
        ]));
        $response = $request->execute();
        $this->assertTrue(isset($response->transactionResponse));
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
        $this->assertEquals('Ok', $response->getResultCode());
    }

    /**
     * Disabled because the XML is throwing error.
     *
     * "The element 'transactionRequest' in namespace
     * 'AnetApi/xml/v1/schema/AnetApiSchema.xsd' has invalid child element
     * 'authCode' in namespace 'AnetApi/xml/v1/schema/AnetApiSchema.xsd'.
     *
     * List of possible elements expected: 'lineItems, tax, duty, shipping,
     * taxExempt, poNumber, customer, billTo, shipTo, customerIP, cardholderAuthentication,
     * retail, employeeId, transactionSettings, userFields' in namespace
     * 'AnetApi/xml/v1/schema/AnetApiSchema.xsd'."
     *
     * @link http://developer.authorize.net/api/reference/index.html#payment-transactions-capture-funds-authorized-through-another-channel
     *
     */
    public function testCaptureOnlyTransaction()
    {
//        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_ONLY);
//
//        // XML
//        $request = new CreateTransactionRequest($this->configuration, $this->client, $transactionRequest);
//        $response = $request->execute();
//
//        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);
//        $transactionRequest->addData('authCode', $response->transactionResponse->authCode);
//
//        // XML
//        $request = new CreateTransactionRequest($this->configuration, $this->client, $transactionRequest);
//        $response = $request->execute();
//        var_dump($response->contents());
//        $this->assertTrue(isset($response->transactionResponse));
//        $this->assertEquals('I00001', $response->getMessages()[0]->code);
//        $this->assertEquals('Successful.', $response->getMessages()[0]->text);
//        $this->assertEquals('Ok', $response->getResultCode());
    }

    /**
     * Not tested, because the transaction needs to be settled.
     *
     * Here for documentation purposes.
     */
    public function testRefundTransaction()
    {
        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);
        $request = new CreateTransactionRequest($this->configuration, $this->client, $transactionRequest);
        $response = $request->execute();


        $request = new CreateTransactionRequest($this->configuration, $this->client);
        $request->setTransactionRequest(new TransactionRequest([
          'transactionType' => TransactionRequest::REFUND,
          'amount' => 5.00,
          'refTransId' => $response->transactionResponse->transId
        ]));
        $transactionRequest->addPayment(new CreditCard([
          'cardNumber' => '1111',
          'expirationDate' => '1230',
        ]));

//        $response = $request->execute();
//        $this->assertTrue(isset($response->transactionResponse));
//        $this->assertEquals('I00001', $response->getMessages()[0]->code);
//        $this->assertEquals('Successful.', $response->getMessages()[0]->text);
//        $this->assertEquals('Ok', $response->getResultCode());
    }

    public function testVoidTransaction()
    {
        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);
        $request = new CreateTransactionRequest($this->configuration, $this->client, $transactionRequest);
        $response = $request->execute();


        $request = new CreateTransactionRequest($this->configuration, $this->client);
        $request->setTransactionRequest(new TransactionRequest([
          'transactionType' => TransactionRequest::VOID,
          'amount' => 5.00,
          'refTransId' => $response->transactionResponse->transId
        ]));

        $response = $request->execute();
        $this->assertTrue(isset($response->transactionResponse));
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
        $this->assertEquals('Ok', $response->getResultCode());
    }

    /**
     * @param $type
     * @return \mglaman\AuthNet\DataTypes\TransactionRequest
     */
    protected function createChargableTransactionRequest($type)
    {
        $transactionRequest = new TransactionRequest([
          'transactionType' => $type,
          'amount' => 5.00,
        ]);
        $transactionRequest->addPayment(new CreditCard([
          'cardNumber' => '4111111111111111',
          'expirationDate' => '1230',
          'cardCode' => '123',
        ]));
        $transactionRequest->addOrder(new Order([
          'invoiceNumber' => 'INV-' . rand(10, 100),
        ]));

        return $transactionRequest;
    }
}
