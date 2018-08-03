<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Paging;
use CommerceGuys\AuthNet\DataTypes\Sorting;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Use this method to cancel subscriptions using Automated Recurring Billing.
 */
class ARBCancelSubscriptionRequest extends ARBSubscriptionRequest
{
    protected $subscriptionId;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $subscriptionId
    ) {
        parent::__construct($configuration, $client);
        $this->subscriptionId = $subscriptionId;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('subscriptionId', $this->subscriptionId);
    }
}
