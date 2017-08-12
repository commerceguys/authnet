<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\Response\ResponseInterface;
use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Configuration;
use CommerceGuys\AuthNet\RequestFactory;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CommerceGuys\AuthNet\Configuration
     */
    protected $configurationXml;

    /**
     * @var \CommerceGuys\AuthNet\Configuration
     */
    protected $configurationJson;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \CommerceGuys\AuthNet\RequestFactory
     */
    protected $xmlRequestFactory;

    /**
     * @var \CommerceGuys\AuthNet\RequestFactory
     */
    protected $jsonRequestFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->configurationXml = new Configuration([
            'api_login' => AUTHORIZENET_API_LOGIN_ID,
            'transaction_key' => AUTHORIZENET_TRANSACTION_KEY,
            'sandbox' => true,
            'certificate_verify' => TESTS_CERTIFICATE_VERIFY,
        ]);
        $this->configurationJson = new Configuration([
            'api_login' => AUTHORIZENET_API_LOGIN_ID,
            'transaction_key' => AUTHORIZENET_TRANSACTION_KEY,
            'sandbox' => true,
            'certificate_verify' => TESTS_CERTIFICATE_VERIFY,
            'request_mode' => 'json',
        ]);
        $this->client = new Client();

        $this->xmlRequestFactory = new RequestFactory($this->configurationXml, $this->client);
        $this->jsonRequestFactory = new RequestFactory($this->configurationJson, $this->client);
    }

    protected function assertResponse(ResponseInterface $response, $expectedCode, $expectedText, $expectedResultCode)
    {
        $message = $response->getMessages()[0];
        // Since this is first possible assert failure, message with response text.
        $this->assertEquals($expectedCode, $message->getCode(), $message->getText());
        $this->assertEquals($expectedText, $message->getText());
        $this->assertEquals($expectedResultCode, $response->getResultCode());
    }
}
