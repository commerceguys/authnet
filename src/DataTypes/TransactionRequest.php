<?php

namespace CommerceGuys\AuthNet\DataTypes;

class TransactionRequest extends BaseDataType
{
    const AUTH_ONLY = 'authOnlyTransaction';
    const PRIOR_AUTH_CAPTURE = 'priorAuthCaptureTransaction';
    const AUTH_CAPTURE = 'authCaptureTransaction';
    const CAPTURE_ONLY = 'captureOnlyTransaction';
    const REFUND = 'refundTransaction';
    const VOID = 'voidTransaction';

    protected $propertyMap = [
        'transactionType',
        'amount',
        'currencyCode',
        'payment',
        'profile',
        'solution',
        'callId',
        'terminalNumber',
        'authCode',
        'refTransId',
        'order',
        'lineItems',
        'tax',
        'duty',
        'shipping',
        'taxExempt',
        'poNumber',
        'customer',
        'billTo',
        'shipTo',
        'customerIP',
        'cardholderAuthentication',
        'retail',
        'employeeId',
        'transactionSettings',
        'userFields',
        'surcharge',
        'merchantDescriptor',
    ];

    protected $properties = [
        'solution' => [
            'id' => 'A1000009',
        ],
    ];

    public function addPayment(PaymentMethodInterface $paymentMethod)
    {
        $this->properties['payment'][$paymentMethod->getType()] = $paymentMethod->toArray();
    }

    public function addOrder(Order $order)
    {
        $this->addDataType($order);
    }

    public function addLineItem(LineItem $lineItem)
    {
        $this->properties['lineItems'][] = [
            $lineItem->getType() => $lineItem->toArray(),
        ];
    }
}
