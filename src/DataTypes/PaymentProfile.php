<?php

namespace CommerceGuys\AuthNet\DataTypes;

// @todo If the billTo element is not before payment, an error occurs.
class PaymentProfile extends BaseDataType
{
    public function addPayment(CreditCard $creditCard)
    {
        $this->properties['payment'][$creditCard->getType()] = $creditCard->toArray();
    }

    public function addBillTo(BillTo $billTo)
    {
        $this->addDataType($billTo);
    }
}
