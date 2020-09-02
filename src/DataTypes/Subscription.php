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
        'billTo',
        'shipTo',
        'profile',
    ];

    public function addPaymentSchedule(PaymentSchedule $paymentSchedule)
    {
        $this->properties['paymentSchedule'] = $paymentSchedule->toArray();
    }

    public function addPayment(PaymentMethodInterface $payment)
    {
        $this->properties['payment'] = $payment->toArray();
    }

    public function addOrder(Order $order)
    {
        $this->addDataType($order);
    }

    public function addBillTo(BillTo $billTo)
    {
        $this->addDataType($billTo);
    }

    public function addShipTo(ShipTo $shipTo)
    {
        $this->addDataType($shipTo);
    }

    public function addProfile(CustomerProfileId $profile)
    {
        $this->properties['profile'] = $profile->toArray();
    }

    public function addAmount(String $amount)
    {
        $this->properties['amount'] = $amount;
    }

    public function getAmount()
    {
        return $this->properties['amount'];
    }

    public function getInterval() {
        return $this->properties['paymentSchedule']['interval'];
    }

    public function removeInterval()
    {
        unset($this->properties['paymentSchedule']['interval']);
    }
}
