<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\Configuration;

/**
 * Tests the configuration class.
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testConfiguration()
    {
        $config = new Configuration([
          'api_login' => AUTHORIZENET_API_LOGIN_ID,
          'transaction_key' => AUTHORIZENET_TRANSACTION_KEY,
          'sandbox' => true,
        ]);

        $this->assertEquals(AUTHORIZENET_API_LOGIN_ID, $config->getApiLogin());
        $this->assertEquals(AUTHORIZENET_TRANSACTION_KEY, $config->getTransactionKey());
        $this->assertTrue($config->getSandbox());

        $config->setSandbox(false);
        $this->assertFalse($config->getSandbox());

        $config->setApiLogin('test');
        $this->assertEquals('test', $config->getApiLogin());

        $config->setTransactionKey('test');
        $this->assertEquals('test', $config->getTransactionKey());

        $config->setRequestMode('json');
        $this->assertEquals('json', $config->getRequestMode());

        $this->assertTrue(strpos($config->getCertificateVerify(), 'resources/cert.pem') !== FALSE);
        $config->setCertificateVerify('/path/to/some/cert.pem');
        $this->assertTrue(strpos($config->getCertificateVerify(), 'resources/cert.pem') === FALSE);
    }
}
