<?php

namespace CommerceGuys\AuthNet;

class Configuration
{
    private $apiLogin;
    private $transactionKey;
    private $sandbox;
    private $requestMode = 'xml';

    public function __construct(array $config)
    {
        // @todo validate and throw invalid argument exception if missing.
        $this->apiLogin = $config['api_login'];
        $this->transactionKey = $config['transaction_key'];
        $this->sandbox = $config['sandbox'];

        if (isset($config['request_mode'])) {
            $this->requestMode = $config['request_mode'];
        }
    }

    /**
     * @return mixed
     */
    public function getApiLogin()
    {
        return $this->apiLogin;
    }

    /**
     * @param mixed $apiLogin
     * @return Configuration
     */
    public function setApiLogin($apiLogin)
    {
        $this->apiLogin = $apiLogin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionKey()
    {
        return $this->transactionKey;
    }

    /**
     * @param mixed $transactionKey
     * @return Configuration
     */
    public function setTransactionKey($transactionKey)
    {
        $this->transactionKey = $transactionKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSandbox()
    {
        return $this->sandbox;
    }

    /**
     * @param mixed $sandbox
     * @return Configuration
     */
    public function setSandbox($sandbox)
    {
        $this->sandbox = $sandbox;
        return $this;
    }

    /**
     * @return mixed|string
     */
    public function getRequestMode()
    {
        return $this->requestMode;
    }

    /**
     * @param mixed|string $requestMode
     * @return Configuration
     */
    public function setRequestMode($requestMode)
    {
        $this->requestMode = $requestMode;
        return $this;
    }
}
