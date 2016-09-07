<?php

namespace mglaman\AuthNet\Tests;

use GuzzleHttp\Client;
use mglaman\AuthNet\Configuration;
use mglaman\AuthNet\RequestFactory;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \mglaman\AuthNet\Configuration
     */
    protected $configuration;
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \mglaman\AuthNet\RequestFactory
     */
    protected $requestFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->configuration = new Configuration([
          'api_login' => AUTHORIZENET_API_LOGIN_ID,
          'transaction_key' => AUTHORIZENET_TRANSACTION_KEY,
          'sandbox' => true,
        ]);
        $this->client = new Client();

        $this->requestFactory = new RequestFactory($this->configuration, $this->client);
    }
}