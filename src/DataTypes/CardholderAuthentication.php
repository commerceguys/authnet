<?php

namespace CommerceGuys\AuthNet\DataTypes;

class CardholderAuthentication extends BaseDataType
{

    protected $propertyMap = [
        'authenticationIndicator',
        'cardholderAuthenticationValue',
    ];
}
