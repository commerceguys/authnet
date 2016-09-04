<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\DataTypes\MerchantAuthentication;
use mglaman\AuthNet\Request\JsonRequest;
use mglaman\AuthNet\Request\XmlRequest;
use mglaman\AuthNet\Response\JsonResponse;

abstract class BaseApiRequest
{
    /**
     * @var \mglaman\AuthNet\Configuration
     */
    protected $configuration;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    protected $merchantAuthentication;

    /**
     * BaseRequest constructor.
     *
     * @param \mglaman\AuthNet\Configuration $configuration
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Configuration $configuration, Client $client)
    {
        $this->configuration = $configuration;
        $this->client = $client;
        $this->merchantAuthentication = new MerchantAuthentication([
          'name' => $this->configuration->getApiLogin(),
          'transactionKey' => $this->configuration->getTransactionKey(),
        ]);
    }

    /**
     * @return \mglaman\AuthNet\Request\RequestInterface
     */
    protected function preparedRequest()
    {
        if ($this->configuration->getRequestMode() == 'json') {
            $request = new JsonRequest($this->configuration, $this->client, 'createTransactionRequest');
        } else {
            $request = new XmlRequest($this->configuration, $this->client, 'createTransactionRequest');
        }

        $request->addDataType($this->merchantAuthentication);
        return $request;
    }

    // @todo make ApiRequestInterface.
    abstract public function execute();
}
