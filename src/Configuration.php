<?php

namespace CommerceGuys\AuthNet;

class Configuration
{
    private $apiLogin;
    private $transactionKey;
    private $sandbox;
    private $requestMode = 'xml';
    private $certificateVerify;

    public function __construct(array $config)
    {
        foreach (['api_login', 'transaction_key', 'sandbox'] as $required_key) {
            if (!isset($config[$required_key])) {
                throw new \InvalidArgumentException("You must provide a value for $required_key");
            }
        }
        $this->apiLogin = $config['api_login'];
        $this->transactionKey = $config['transaction_key'];
        $this->sandbox = $config['sandbox'];

        if (isset($config['request_mode'])) {
            $this->requestMode = $config['request_mode'];
        }

        if (isset($config['certificate_verify'])) {
            $this->certificateVerify = $config['certificate_verify'];
        } elseif ($cert = ini_get('curl.cainfo')) {
            $this->certificateVerify = $cert;
        } else {
            $this->certificateVerify = __DIR__ . '/../resources/cert.pem';
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

    /**
     * @return mixed|string
     */
    public function getCertificateVerify()
    {
        return $this->certificateVerify;
    }

    /**
     * @param mixed|string $value
     * @return Configuration
     */
    public function setCertificateVerify($value)
    {
        $this->certificateVerify = $value;
        return $this;
    }
}
