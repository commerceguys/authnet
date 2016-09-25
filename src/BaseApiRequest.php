<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\MerchantAuthentication;
use CommerceGuys\AuthNet\Request\JsonRequest;
use CommerceGuys\AuthNet\Request\RequestInterface;
use CommerceGuys\AuthNet\Request\XmlRequest;
use CommerceGuys\AuthNet\Response\JsonResponse;

abstract class BaseApiRequest implements ApiRequestInterface
{
    /**
     * @var \CommerceGuys\AuthNet\Configuration
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
     * @param \CommerceGuys\AuthNet\Configuration $configuration
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
     * @param \CommerceGuys\AuthNet\Request\RequestInterface $request
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
        $request->addData('clientId', 'CG-PHP-SDK');
        $request->addData('refId', 'ref' . time());
        $this->attachData($request);

        $response = $request->sendRequest();
        return $response;
    }
}
