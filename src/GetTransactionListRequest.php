<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Retrieve detailed information about a specific transaction.
 *
 * @link https://developer.authorize.net/api/reference/index.html#transaction-reporting-get-transaction-list
 */
class GetTransactionListRequest extends BaseApiRequest
{
    protected $batchId;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $batchId
    ) {
        parent::__construct($configuration, $client);
        $this->batchId = $batchId;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('batchId', $this->batchId);
    }
}
