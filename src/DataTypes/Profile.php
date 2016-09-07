<?php

namespace CommerceGuys\AuthNet\DataTypes;

class Profile extends BaseDataType
{
    public function addPaymentProfile(PaymentProfile $profile)
    {
        $this->properties['paymentProfiles'] = $profile->toArray();
    }
}
