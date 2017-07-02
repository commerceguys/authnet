<?php

namespace CommerceGuys\AuthNet\DataTypes;

class LineItem extends BaseDataType
{

    protected $propertyMap = [
        'itemId',
        'name',
        'description',
        'quantity',
        // Price of an item per unit, excluding tax, freight, and duty.
        'unitPrice',
    ];
}
