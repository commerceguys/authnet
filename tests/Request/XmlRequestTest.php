<?php

namespace mglaman\AuthNet\Tests\Request;

use GuzzleHttp\Client;
use mglaman\AuthNet\Configuration;
use mglaman\AuthNet\DataTypes\MerchantAuthentication;
use mglaman\AuthNet\Request\XmlRequest;

class XmlRequestTest extends \PHPUnit_Framework_TestCase
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

    public function testXmlRequest()
    {
        $request = new XmlRequest($this->configuration, $this->client, 'authenticateTestRequest');
        $request->addDataType(new MerchantAuthentication([
          'name' => $this->configuration->getApiLogin(),
          'transactionKey' => $this->configuration->getTransactionKey(),
        ]));
        $this->assertEquals('text/xml', $request->getContentType());

        $expected = '<?xml version="1.0"?>
<authenticateTestRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"><merchantAuthentication><name>' . $this->configuration->getApiLogin() . '</name><transactionKey>' . $this->configuration->getTransactionKey() . '</transactionKey></merchantAuthentication></authenticateTestRequest>';
        $this->assertEquals($expected, trim($request->getBody()));
    }

}