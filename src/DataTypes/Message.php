<?php

namespace CommerceGuys\AuthNet\DataTypes;

class Message extends BaseDataType
{
    protected function validate(array $values)
    {
        if (!isset($values['code'])) {
            throw new \InvalidArgumentException('Messages must have a code');
        }
        if (!isset($values['text'])) {
            throw new \InvalidArgumentException('Messages must have a text');
        }
    }

    public function getCode()
    {
        return $this->properties['code'];
    }

    public function getText()
    {
        return $this->properties['text'];
    }
}
