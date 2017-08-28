<?php

namespace CommerceGuys\AuthNet\DataTypes;

class OpaqueData extends BaseDataType implements PaymentMethodInterface
{

    const NONCE = 'COMMON.ACCEPT.INAPP.PAYMENT';
    const APPLE_PAY = 'COMMON.APPLE.INAPP.PAYMENT';
    const ANDROID_PAY = 'COMMON.ANDROID.INAPP.PAYMENT';
    const VISA_CHECKOUT = 'COMMON.VCO.ONLINE.PAYMENT';

    protected $propertyMap = [
        'dataDescriptor',
        'dataValue',
        'dataKey',
    ];
}
