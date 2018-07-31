<?php

namespace CommerceGuys\AuthNet\DataTypes;

class CustomerPaymentProfileBase extends BaseDataType
{

    protected $propertyMap = [
        'customerType',
        'billTo',
    ];

    public function addBillTo(BillTo $billTo)
    {
        $this->addDataType($billTo);
    }
}
