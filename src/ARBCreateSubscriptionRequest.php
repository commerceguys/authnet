<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\SubscriptionRequest;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Use this method to create subscriptions using Automated Recurring Billing.
 *
 * @link https://developer.authorize.net/api/reference/#recurring-billing
 */
class ARBCreateSubscriptionRequest extends BaseApiRequest
{
    protected $subscriptionRequest;

    public function __construct(
        Configuration $configuration,
        Client $client,
        Subscription $subscription = null
    ) {
        parent::__construct($configuration, $client);
        $this->subscriptionRequest = $subscription;
    }

    /**
     * @param \CommerceGuys\AuthNet\DataTypes\SubscriptionRequest $subscriptionRequest
     * @return $this
     */
    public function setSubscriptionRequest(SubscriptionRequest $subscriptionRequest)
    {
        $this->subscriptionRequest = $subscription;
        return $this;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addDataType($this->subscriptionRequest);
    }
}
