<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\DataTypes\TransactionRequest;

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
     */
    public function setTransactionRequest($transactionRequest)
    {
        $this->transactionRequest = $transactionRequest;
    }

    public function getType()
    {
        return 'createTransactionRequest';
    }


    public function execute()
    {
        $request = $this->preparedRequest();
        $request->addData('refId', 'ref' . time());
        $request->addDataType($this->transactionRequest);
        $response = $request->sendRequest();
        return $response;
    }
}
