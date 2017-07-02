<?php

namespace CommerceGuys\AuthNet\DataTypes;

class BankAccount extends BaseDataType implements PaymentMethodInterface
{
    protected $propertyMap = [
        'accountType',
        // Format of routingNumber should be nine digits or four X's followed by the last four digits.
        'routingNumber',
        // Format of accountNumber should be numeric string or four X's followed by the last four digits.
        'accountNumber',
        'nameOnAccount',
        'echeckType',
        'bankName',
        'checkNumber',
    ];
}
