<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\Message;

class DataTypeTest extends TestBase
{
    public function testBaseDataType()
    {
        // Tests methods provided by \CommerceGuys\AuthNet\DataTypes\BaseDataType
        $creditCard = new CreditCard([
            'cardNumber' => '4111111111111111',
            'expirationDate' => '2025-12',
        ]);
        unset($creditCard->cardNumber);
        $this->assertTrue(!isset($creditCard->cardNumber));
        $creditCard->addData('cardNumber', '5424000000000015');
        $this->assertEquals('5424000000000015', $creditCard->cardNumber);
    }

    public function testMessageValidationCode()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Messages must have a code');
        new Message(['message' => 'Test']);
    }

    public function testMessageValidationTest()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Messages must have a text');
        new Message(['code' => 'I00122']);
    }
}
