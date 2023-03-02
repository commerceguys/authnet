<?php

namespace CommerceGuys\AuthNet;

/**
 * Use this method to create subscriptions using Automated Recurring Billing.
 *
 * @link https://developer.authorize.net/api/reference/#recurring-billing
 */
abstract class ARBSubscriptionRequest extends BaseApiRequest
{

    public function getType()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
