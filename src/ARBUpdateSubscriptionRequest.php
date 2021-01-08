<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Subscription;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Use this method to update subscriptions using Automated Recurring Billing.
 */
class ARBUpdateSubscriptionRequest extends ARBCreateSubscriptionRequest
{
    protected $subscriptionId;

    public function __construct(
        Configuration $configuration,
        Client $client,
        Subscription $subscription,
        string $subscriptionId
    ) {
        $this->subscriptionId = $subscriptionId;
        // Authnet does not allow an interval to be updated
        $subscription->removeInterval();
        parent::__construct($configuration, $client, $subscription);
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('subscriptionId', $this->subscriptionId);
        parent::attachData($request);
    }
}
