<?php

namespace CommerceGuys\AuthNet\DataTypes;

class ShipTo extends BaseDataType
{

    protected $propertyMap = [
        'firstName',
        'lastName',
        'company',
        'address',
        'city',
        'state',
        'zip',
        'country',
    ];
}
