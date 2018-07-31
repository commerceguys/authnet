<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 7/31/18
 * Time: 10:23 AM
 */

namespace CommerceGuys\AuthNet\DataTypes;


class CustomerProfileId extends BaseDataType
{

    protected $propertyMap = [
        'customerProfileId',
        'customerPaymentProfileId',
        'customerAddressId',
    ];
}
