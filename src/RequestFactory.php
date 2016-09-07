<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;

/**
 * @method CreateTransactionRequest createTransactionRequest()
 */
class RequestFactory
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
     * BaseRequest constructor.
     *
     * @param \mglaman\AuthNet\Configuration $configuration
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Configuration $configuration, Client $client)
    {
        $this->configuration = $configuration;
        $this->client = $client;
    }

    public function __call($name, $args = null)
    {

        $class = '\\' . (new \ReflectionClass($this))->getNamespaceName() . '\\' . ucfirst($name);
        if (!class_exists($class)) {
            throw new \InvalidArgumentException("Request $name does not exist");
        }

        if (!(new \ReflectionClass($class))->implementsInterface(ApiRequestInterface::class)) {
            throw new \InvalidArgumentException("Request $name is not a valid request");
        }

        $instance = new $class($this->configuration, $this->client);

        return $instance;
    }
}
