<?php

namespace CommerceGuys\AuthNet\DataTypes;

class SubscriptionRequest extends BaseDataType
{
    protected $propertyMap = [
        'subscription',
    ];

    public function addSubscription(Subscription $subscription)
    {
        $this->properties['subscription'] = $subscription;
    }
}
