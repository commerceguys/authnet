<?php

namespace CommerceGuys\AuthNet\DataTypes;

class PaymentSchedule extends BaseDataType
{
    protected $propertyMap = [
        'interval',
        'startDate',
        'totalOccurrences',
        'trialOccurrences',
    ];

    public function addInterval(Interval $interval)
    {
        $this->properties['interval'] = $interval->toArray();
    }
}
