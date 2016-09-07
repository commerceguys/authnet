<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\DataTypes\MerchantAuthentication;
use mglaman\AuthNet\Request\JsonRequest;
use mglaman\AuthNet\Request\RequestInterface;
use mglaman\AuthNet\Request\XmlRequest;
use mglaman\AuthNet\Response\JsonResponse;

abstract class BaseApiRequest implements ApiRequestInterface
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

    public function getType()
    {
        return lcfirst((new \ReflectionClass($this))->getShortName());
    }

    /**
     * Allows child classes to attach data to the request.
     *
     * @param \mglaman\AuthNet\Request\RequestInterface $request
     * @return RequestInterface
     */
    abstract protected function attachData(RequestInterface $request);

    public function execute()
    {
        if ($this->configuration->getRequestMode() == 'json') {
            $request = new JsonRequest($this->configuration, $this->client, $this->getType());
        } else {
            $request = new XmlRequest($this->configuration, $this->client, $this->getType());
        }

        $request->addDataType($this->merchantAuthentication);

        $this->attachData($request);

        $response = $request->sendRequest();
        return $response;
    }
}
