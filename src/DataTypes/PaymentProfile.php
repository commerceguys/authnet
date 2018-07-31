<?php

namespace CommerceGuys\AuthNet\DataTypes;

class PaymentProfile extends CustomerPaymentProfileBase
{

    protected $propertyMap = [
        'customerType',
        'billTo',
        'payment',
        'defaultPaymentProfile',
        'customerPaymentProfileId'
    ];

    public function addPayment(PaymentMethodInterface $paymentMethod)
    {
        $this->properties['payment'][$paymentMethod->getType()] = $paymentMethod->toArray();
    }

    public function addCustomerPaymentProfileId($id)
    {
        $this->properties['customerPaymentProfileId'] = $id;
    }
}
