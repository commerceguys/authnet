<?php

namespace mglaman\AuthNet\DataTypes;

abstract class BaseDataType implements DataTypeInterface
{
    protected $properties;

    public function __construct(array $values = [])
    {
        foreach ($values as $name => $value) {
            $this->$name = $value;
        }
    }

    public function toArray()
    {
        return $this->properties;
    }

    public function getType()
    {
        return lcfirst((new \ReflectionClass($this))->getShortName());
    }

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function __unset($name)
    {
        unset($this->properties[$name]);
    }

    public function addData($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function addDataType(DataTypeInterface $data)
    {
        $this->properties[$data->getType()] = $data->toArray();
    }
}
