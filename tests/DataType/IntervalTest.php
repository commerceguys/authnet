<?php

namespace CommerceGuys\AuthNet\Tests\DataType;

use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\Interval;
use CommerceGuys\AuthNet\DataTypes\LineItem;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

/**
 * Tests Intervals.
 */
class IntervalTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test validate logic.
     */
    public function testMissingLength()
    {
        $this->setExpectedException(\InvalidArgumentException::class, 'Interval must have a length.');
        $interval = new Interval();
    }

    /**
     * Test validate logic.
     */
    public function testMissingUnit()
    {
        $this->setExpectedException(\InvalidArgumentException::class, 'Interval must have a unit.');
        $interval = new Interval(['length' => '1']);
    }

    /**
     * Test validate logic.
     */
    public function testInvalidUnit()
    {
        $this->setExpectedException(\InvalidArgumentException::class, 'Interval unit must be days or months.');
        $interval = new Interval(['length' => '1', 'unit' => 'foo']);
    }

    /**
     * Test validate logic.
     */
    public function testUnitDays()
    {
        $this->setExpectedException(\InvalidArgumentException::class, 'Interval length for days must be between 7 and 365, inclusive.');
        $interval = new Interval(['length' => '1', 'unit' => 'days']);
    }

    /**
     * Test validate logic.
     */
    public function testUnitMonths()
    {
        $this->setExpectedException(\InvalidArgumentException::class, 'Interval length for months must be between 1 and 12, inclusive.');
        $interval = new Interval(['length' => '13', 'unit' => 'months']);
    }
}
