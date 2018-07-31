<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Subscription;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Use this method to create subscriptions using Automated Recurring Billing.
 */
class ARBCreateSubscriptionRequest extends ARBSubscriptionRequest
{
    protected $subscription;

    public function __construct(
        Configuration $configuration,
        Client $client,
        Subscription $subscription = null
    ) {
        parent::__construct($configuration, $client);
        $this->subscription = $subscription;
    }

    /**
     * @param \CommerceGuys\AuthNet\DataTypes\Subscription $subscription
     * @return $this
     */
    public function setSubscription(Subscription $subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addDataType($this->subscription);
    }
}
