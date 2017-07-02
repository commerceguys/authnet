<?php

namespace CommerceGuys\AuthNet\DataTypes;

class Profile extends BaseDataType
{
    protected $propertyMap = [
        'merchantCustomerId',
        'description',
        'email',
        'paymentProfiles',
    ];

    public function addPaymentProfile(PaymentProfile $profile)
    {
        $this->properties['paymentProfiles'] = $profile->toArray();
    }
}
