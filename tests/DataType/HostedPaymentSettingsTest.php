<?php

namespace CommerceGuys\AuthNet\Tests\DataType;

use CommerceGuys\AuthNet\DataTypes\HostedPaymentSettings;
use CommerceGuys\AuthNet\DataTypes\Setting;
use PHPUnit\Framework\TestCase;

/**
 * Tests the HostedPaymentSettings class.
 */
class HostedPaymentSettingsTest extends TestCase
{
    /**
     * Tests that settings are added and structured properly.
     */
    public function testAddSingleSetting()
    {
        $settingName = 'hostedPaymentReturnOptions';
        $settingValue = [
            'showReceipt' => false,
            'url' => 'https://example.com/return',
        ];
        $settings = new HostedPaymentSettings();
        $settings->addSetting(new Setting($settingName, $settingValue));

        $array = $settings->toArray();

        $this->assertCount(1, $array);
        $this->assertArrayHasKey('setting', $array[0]);
        $this->assertEquals('hostedPaymentReturnOptions', $array[0]['setting']['settingName']);

        $expectedValue = json_encode($settingValue);
        $this->assertJsonStringEqualsJsonString($expectedValue, $array[0]['setting']['settingValue']);
    }

    /**
     * Tests adding multiple settings.
     */
    public function testAddMultipleSettings()
    {
        $settings = new HostedPaymentSettings();

        $settings->addSetting(new Setting('hostedPaymentBillingAddressOptions', ['show' => false]));
        $settings->addSetting(new Setting('hostedPaymentSecurityOptions', ['captcha' => true]));

        $array = $settings->toArray();

        $this->assertCount(2, $array);

        $this->assertEquals('hostedPaymentBillingAddressOptions', $array[0]['setting']['settingName']);
        $this->assertEquals(json_encode(['show' => false]), $array[0]['setting']['settingValue']);

        $this->assertEquals('hostedPaymentSecurityOptions', $array[1]['setting']['settingName']);
        $this->assertEquals(json_encode(['captcha' => true]), $array[1]['setting']['settingValue']);
    }

    /**
     * Tests that a scalar string value does not get double-encoded.
     */
    public function testScalarSettingValue()
    {
        $settings = new HostedPaymentSettings();
        $settings->addSetting(new Setting('customLabel', 'Some Value'));

        $array = $settings->toArray();

        $this->assertEquals('Some Value', $array[0]['setting']['settingValue']);
    }
}
