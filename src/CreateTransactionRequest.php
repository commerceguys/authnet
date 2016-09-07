<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\DataTypes\TransactionRequest;
use mglaman\AuthNet\Request\RequestInterface;

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
     * @param \mglaman\AuthNet\DataTypes\TransactionRequest $transactionRequest
     * @return $this
     */
    public function setTransactionRequest($transactionRequest)
    {
        $this->transactionRequest = $transactionRequest;
        return $this;
    }

    public function getType()
    {
        return 'createTransactionRequest';
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('refId', 'ref' . time());
        $request->addDataType($this->transactionRequest);
    }
}
