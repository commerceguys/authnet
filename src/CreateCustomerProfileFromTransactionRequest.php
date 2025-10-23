<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Creates a customer profile, payment profile, and shipping address
 * from an existing successful transaction.
 *
 * This request uses a transaction ID (`transId`) from a prior successful
 * payment to generate a new customer profile in Authorize.Net.
 *
 * @link https://developer.authorize.net/api/reference/index.html#customer-profiles-create-a-customer-profile-from-a-transaction
 */
class CreateCustomerProfileFromTransactionRequest extends BaseApiRequest
{
    /**
     * @var string The transaction ID from a successful payment.
     */
    protected $transId;

    /**
     * Constructs a new CreateCustomerProfileFromTransactionRequest object.
     *
     * @param Configuration $configuration
     *   The configuration object containing API credentials.
     * @param Client $client
     *   The HTTP client for making requests.
     * @param string $transId
     *   The transaction ID from an existing successful transaction.
     */
    public function __construct(
        Configuration $configuration,
        Client $client,
        $transId
    ) {
        parent::__construct($configuration, $client);
        $this->transId = $transId;
    }

    /**
     * {@inheritdoc}
     */
    protected function attachData(RequestInterface $request)
    {
        $request->addData('transId', $this->transId);
    }
}
