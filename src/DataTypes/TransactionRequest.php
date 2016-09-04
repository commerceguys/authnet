<?php

namespace mglaman\AuthNet\DataTypes;

class TransactionRequest extends BaseDataType
{
    const AUTH_ONLY = 'authOnlyTransaction';
    const PRIOR_AUTH_CAPTURE = 'priorAuthCaptureTransaction';
    const AUTH_CAPTURE = 'authCaptureTransaction';
    const CAPTURE_ONLY = 'captureOnlyTransaction';
    const REFUND = 'refundTransaction';
    const VOID = 'voidTransaction';

    public function getType()
    {
        return 'transactionRequest';
    }

    public function addPayment(CreditCard $creditCard)
    {
        $this->properties['payment'][$creditCard->getType()] = $creditCard->toArray();
    }
    public function addOrder(Order $order)
    {
        $this->addDataType($order);
    }
    public function addLineItem(LineItem $lineItem)
    {
        $this->properties['lineItems'][$lineItem->getType()] = $lineItem->toArray();
    }
}
