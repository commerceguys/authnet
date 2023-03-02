<?php

namespace CommerceGuys\AuthNet\Tests\DataType;

use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\Interval;
use CommerceGuys\AuthNet\DataTypes\LineItem;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;
use PHPUnit\Framework\TestCase;

/**
 * Tests Intervals.
 */
class IntervalTest extends TestCase
{

    /**
     * Test validate logic.
     */
    public function testMissingLength()
    {
        $this->expectExceptionMessage('Interval must have a length.');
        $this->expectException(\InvalidArgumentException::class);
        new Interval();
    }

    /**
     * Test validate logic.
     */
    public function testMissingUnit()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval must have a unit.');
        new Interval(['length' => '1']);
    }

    /**
     * Test validate logic.
     */
    public function testInvalidUnit()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval unit must be days or months.');
        new Interval(['length' => '1', 'unit' => 'foo']);
    }

    /**
     * Test validate logic.
     */
    public function testUnitDays()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval length for days must be between 7 and 365, inclusive.');
        new Interval(['length' => '1', 'unit' => 'days']);
    }

    /**
     * Test validate logic.
     */
    public function testUnitMonths()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Interval length for months must be between 1 and 12, inclusive.');
        new Interval(['length' => '13', 'unit' => 'months']);
    }
}
