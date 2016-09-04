<?php

namespace mglaman\AuthNet\Tests\Request;

use GuzzleHttp\Client;
use mglaman\AuthNet\Configuration;
use mglaman\AuthNet\DataTypes\MerchantAuthentication;
use mglaman\AuthNet\Request\JsonRequest;

class JsonRequestTest extends \PHPUnit_Framework_TestCase
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

    public function testJsonRequest()
    {
        $request = new JsonRequest($this->configuration, $this->client, 'authenticateTestRequest');
        $request->addDataType(new MerchantAuthentication([
          'name' => $this->configuration->getApiLogin(),
          'transactionKey' => $this->configuration->getTransactionKey(),
        ]));
        $this->assertEquals('application/json', $request->getContentType());

        $expected = '{"authenticateTestRequest":{"merchantAuthentication":{"name":"5KP3u95bQpv","transactionKey":"346HZ32z3fP4hTG2"}}}';
        $this->assertEquals($expected, trim($request->getBody()));
    }

}