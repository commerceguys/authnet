<?php

namespace CommerceGuys\AuthNet\DataTypes;

class Subscription extends BaseDataType
{
    protected $propertyMap = [
        'name',
        'paymentSchedule',
        'amount',
        'trialAmount',
        'payment',
        'order',
        'customer',
        'billTo',
        'shipTo',
    ];

    public function addPaymentSchedule(PaymentSchedule $paymentSchedule)
    {
        $this->properties['paymentSchedule'] = $paymentSchedule->toArray();
    }

    public function addPayment(PaymentMethodInterface $paymentMethod)
    {
        $this->properties['payment'][$paymentMethod->getType()] = $paymentMethod->toArray();
    }

    public function addOrder(Order $order)
    {
        $this->addDataType($order);
    }
}
