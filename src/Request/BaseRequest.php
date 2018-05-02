<?php

namespace CommerceGuys\AuthNet\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use CommerceGuys\AuthNet\Configuration;
use CommerceGuys\AuthNet\DataTypes\DataTypeInterface;
use CommerceGuys\AuthNet\Exception\AuthNetException;
use CommerceGuys\AuthNet\Response\JsonResponse;
use CommerceGuys\AuthNet\Response\XmlResponse;

/**
 * Class AuthNetRequest
 * @package CommerceGuys\AuthNet\Request
 */
abstract class BaseRequest implements RequestInterface
{

    const SANDBOX = 'https://apitest.authorize.net/xml/v1/request.api';
    const LIVE = 'https://api2.authorize.net/xml/v1/request.api';

    /**
     * @var \CommerceGuys\AuthNet\Configuration
     */
    protected $configuration;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The request type.
     *
     * For example, createTransactionRequest or authenticateTestRequest.
     *
     * @var string
     */
    protected $type;

    protected $data = [];
    /**
     * BaseRequest constructor.
     *
     * @param \CommerceGuys\AuthNet\Configuration $configuration
     * @param \GuzzleHttp\Client $client
     * @param string $type
     * @param array $data
     */
    public function __construct(Configuration $configuration, Client $client, $type, array $data = [])
    {
        $this->configuration = $configuration;
        $this->client = $client;
        $this->type = $type;
        $this->data = $data;
    }

    public function addDataType(DataTypeInterface $data)
    {
        $this->data[$data->getType()] = $data->toArray();
    }

    /**
     * @param $name
     * @param $value
     */
    public function addData($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @return \CommerceGuys\AuthNet\Response\ResponseInterface
     * @throws \CommerceGuys\AuthNet\Exception\AuthNetException
     */
    public function sendRequest()
    {
        $postUrl = ($this->configuration->getSandbox()) ? self::SANDBOX : self::LIVE;
        $opts = $this->requestOptions();
        try {
            $response = $this->client->post($postUrl, $opts);

            if ($response->getStatusCode() != 200) {
                throw new AuthNetException("The request returned with error code {$response->getStatusCode()}");
            } elseif (!$response->getBody()) {
                throw new AuthNetException("The request did not have a body");
            }
        } catch (RequestException $e) {
            throw new AuthNetException($e->getMessage(), $e->getCode(), $e);
        }

        if ($this->configuration->getRequestMode() == 'json') {
            return new JsonResponse($response);
        } else {
            return new XmlResponse($response);
        }
    }

    /**
     * @return array
     */
    protected function requestOptions()
    {
        $opts = [
            'verify' => $this->configuration->getCertificateVerify(),
            'headers' => [
              'Content-Type' => $this->getContentType(),
            ],
            'body' => $this->getBody(),
        ];
        return $opts;
    }
}
