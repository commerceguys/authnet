<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Retrieve detailed information about a specific transaction.
 *
 * @link http://developer.authorize.net/api/reference/index.html#transaction-reporting-get-transaction-details
 */
class GetTransactionDetailsRequest extends BaseApiRequest
{
    protected $transId;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $transId
    ) {
        parent::__construct($configuration, $client);
        $this->transId = $transId;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('transId', $this->transId);
    }
}
