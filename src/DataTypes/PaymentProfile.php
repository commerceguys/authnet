<?php

namespace CommerceGuys\AuthNet\DataTypes;

class PaymentProfile extends BaseDataType
{

    protected $propertyMap = [
        'customerType',
        'billTo',
        'payment',
        'defaultPaymentProfile',
    ];

    public function addPayment(PaymentMethodInterface $paymentMethod)
    {
        $this->properties['payment'][$paymentMethod->getType()] = $paymentMethod->toArray();
    }

    public function addBillTo(BillTo $billTo)
    {
        $this->addDataType($billTo);
    }
}
