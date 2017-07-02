<?php

namespace CommerceGuys\AuthNet\DataTypes;

class CreditCard extends BaseDataType implements PaymentMethodInterface
{

    protected $propertyMap = [
        'cardNumber',
        'expirationDate',
        'cardCode',
    ];
}
