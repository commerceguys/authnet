<?php

namespace mglaman\AuthNet\DataTypes;

interface DataTypeInterface
{
    public function getType();
    public function toArray();
    public function addData($name, $value);
    public function addDataType(DataTypeInterface $data);
}
