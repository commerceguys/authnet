<?php

namespace CommerceGuys\AuthNet\DataTypes;

class Interval extends BaseDataType
{
    protected $propertyMap = [
        'length',
        'unit',
    ];

    /**
     * Allows child classes to validate incoming values.
     *
     * @param array $values
     */
    protected function validate(array $values)
    {
        if (!isset($values['length'])) {
            throw new \InvalidArgumentException('Interval must have a length.');
        }
        if (!isset($values['unit'])) {
            throw new \InvalidArgumentException('Interval must have a unit.');
        }
        if (!array_intersect(['days', 'months'], (array) $values['unit'])) {
            throw new \InvalidArgumentException('Interval unit must be days or months.');
        }
        switch ($values['unit']) {
            case 'days':
                if ($values['length'] < 7 || $values['length'] > 365) {
                    $message = 'Interval length for days must be between 7 and 365, inclusive.';
                    throw new \InvalidArgumentException($message);
                }
                break;

            case 'months':
                if ($values['length'] < 1 || $values['length'] > 12) {
                    $message = 'Interval length for months must be between 1 and 12, inclusive.';
                    throw new \InvalidArgumentException($message);
                }
                break;
        }
    }
}
