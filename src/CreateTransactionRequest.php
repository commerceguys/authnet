<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Use this method to authorize and capture a credit card payment.
 *
 * @link http://developer.authorize.net/api/reference/index.html#payment-transactions-charge-a-credit-card
 */
class CreateTransactionRequest extends BaseApiRequest
{
    protected $transactionRequest;

    public function __construct(
        Configuration $configuration,
        Client $client,
        TransactionRequest $transactionRequest = null
    ) {
        parent::__construct($configuration, $client);
        $this->transactionRequest = $transactionRequest;
    }

    /**
     * @param \CommerceGuys\AuthNet\DataTypes\TransactionRequest $transactionRequest
     * @return $this
     */
    public function setTransactionRequest($transactionRequest)
    {
        $this->transactionRequest = $transactionRequest;
        return $this;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addDataType($this->transactionRequest);
    }
}
