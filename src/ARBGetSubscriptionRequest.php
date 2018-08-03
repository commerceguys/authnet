<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Paging;
use CommerceGuys\AuthNet\DataTypes\Sorting;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Use this method to get a subscription using Automated Recurring Billing.
 */
class ARBGetSubscriptionRequest extends ARBSubscriptionRequest
{
    protected $subscriptionId;
    protected $includeTransactions;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $subscriptionId,
        $includeTransactions = false
    ) {
        parent::__construct($configuration, $client);
        $this->subscriptionId = $subscriptionId;
        $this->includeTransactions = filter_var($includeTransactions, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('subscriptionId', $this->subscriptionId);
        $request->addData('includeTransactions', $this->includeTransactions);
    }
}
