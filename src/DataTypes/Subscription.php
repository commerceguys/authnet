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

    public function addAmount(string $amount)
    {
        $this->properties['amount'] = $amount;
    }

    public function getAmount()
    {
        return $this->properties['amount'];
    }

    public function getInterval() {
        if(is_array($this->properties['paymentSchedule'])) {
            return $this->properties['paymentSchedule']['interval'];
        }
        return $this->properties['paymentSchedule']->interval;
    }

    public function getPaymentSchedule() {
        return $this->properties['paymentSchedule'];
    }

    public function removeInterval()
    {
        unset($this->properties['paymentSchedule']['interval']);
    }

    public function getStartDate()
    {
        if(is_array($this->properties['paymentSchedule'])) {
            return $this->properties['paymentSchedule']['startDate'];
        }
        return $this->properties['paymentSchedule']->startDate;
    }

    public function addStartDate(string $startDate)
    {
        if(is_object($this->properties['paymentSchedule'])) {
            $this->properties['paymentSchedule']->startDate = $startDate;
        }
        $this->properties['paymentSchedule']['startDate'] = $startDate;
    }

    public function removeStartDate() {
        unset($this->properties['paymentSchedule']['startDate']);
    }

    public function getArbTransactions() {
        return $this->properties['arbTransactions'];
    }

    public function addArbTransactions($arbTransactions)  {
        if( is_array($arbTransactions)) {
            $arbTransactions = $arbTransactions['arbTransaction'];
        }
        else {
            $arbTransactions = $arbTransactions->arbTransaction;
        }
        foreach( $arbTransactions as $arbTransaction ) {
            $this->properties['arbTransactions']['arbTransaction'][] = (array) $arbTransaction;
        }
    }

    public function addArbTransaction(ArbTransaction $arbTransaction) {
        $this->properties['arbTransactions']['arbTransaction'][] = $arbTransaction->toArray();
    }
}
