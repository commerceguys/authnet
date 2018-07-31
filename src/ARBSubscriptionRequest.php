<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Paging;
use CommerceGuys\AuthNet\DataTypes\Sorting;
use CommerceGuys\AuthNet\Request\RequestInterface;

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
