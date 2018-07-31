<?php

namespace CommerceGuys\AuthNet\DataTypes;

class Sorting extends BaseDataType
{

    protected $propertyMap = [
        'orderBy',
        'orderDescending',
    ];

    public function __construct(array $values = [])
    {
        $this->validate($values);
        foreach ($values as $name => $value) {
            $this->$name = $value;
            if ($name == 'orderDescending') {
                $this->$name = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
            }
        }
    }
}
