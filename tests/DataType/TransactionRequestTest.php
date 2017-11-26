<?php

namespace CommerceGuys\AuthNet\Tests\DataType;

use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\LineItem;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

/**
 * Tests the transaction request
 */
class TransactionRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests ::addPayment
     */
    public function testAddPayment()
    {
        $transactionRequest = new TransactionRequest([]);
        $transactionRequest->addPayment(new CreditCard([
            'cardNumber' => 'XXXX1111',
            'expirationDate' => '0122',
            'cardCode' => '123',
        ]));

        $array = $transactionRequest->toArray();
        $this->assertEquals([
            'cardNumber' => 'XXXX1111',
            'expirationDate' => '0122',
            'cardCode' => '123',
        ], $array['payment']['creditCard']);
    }

    public function testAddLineItem()
    {
        $transactionRequest = new TransactionRequest([]);
        $sampleLineItems = [
            new LineItem(['name' => 'test1', 'description' => 'testing']),
            new LineItem(['name' => 'test2', 'description' => 'testing']),
            new LineItem(['name' => 'test3', 'description' => 'testing']),
        ];
        foreach ($sampleLineItems as $sampleLineItem) {
            $transactionRequest->addLineItem($sampleLineItem);
        }

        $array = $transactionRequest->toArray();
        $this->assertCount(3, $array['lineItems']);
        $this->assertEquals([
            'lineItem' => [
                'name' => 'test1',
                'description' => 'testing',
            ]
        ], $array['lineItems'][0]);
        $this->assertEquals([
            'lineItem' => [
                'name' => 'test2',
                'description' => 'testing',
            ]
        ], $array['lineItems'][1]);
        $this->assertEquals([
            'lineItem' => [
                'name' => 'test3',
                'description' => 'testing',
            ]
        ], $array['lineItems'][2]);
    }

}
