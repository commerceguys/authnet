<?php

namespace CommerceGuys\AuthNet\DataTypes;

class ArbTransaction extends BaseDataType {
    protected $propertyMap = [
        'transId',
        'response',
        'submitTimeUTC',
        'payNum',
        'attemptNum',
    ];
}
