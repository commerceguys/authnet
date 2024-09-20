<?php

namespace CommerceGuys\AuthNet\DataTypes;

class Customer extends BaseDataType
{
    protected $propertyMap = [
        'type',
        'id',
        'email',
        'driversLicense',
        'taxId',
    ];
}