<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\DataTypes\HostedPaymentSettings;
use CommerceGuys\AuthNet\DataTypes\Setting;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;
use CommerceGuys\AuthNet\GetHostedPaymentPageRequest;
use CommerceGuys\AuthNet\Tests\CreateTransactionRequest\CreateTransactionRequestTestBase;

class GetHostedPaymentPageRequestTest extends CreateTransactionRequestTestBase
{
    /**
     * Tests the Accept Hosted request with XML format.
     */
    public function testGetHostedPaymentPageXml()
    {
        // Minimal valid transaction request for Accept Hosted.
        $transactionRequest = new TransactionRequest([
            'transactionType' => TransactionRequest::AUTH_ONLY,
            'amount' => '50.00',
        ]);
        // Minimal hosted payment settings.
        $hostedSettings = new HostedPaymentSettings();
        $hostedSettings->addSetting(new Setting('hostedPaymentReturnOptions', [
            'showReceipt' => true,
            'url' => 'https://mysite.com/receipt',
            'urlText' => 'Continue',
            'cancelUrl' => 'https://mysite.com/cancel',
            'cancelUrlText' => 'Cancel',
        ]));
        $request = new GetHostedPaymentPageRequest(
            $this->configurationXml,
            $this->client,
            $transactionRequest,
            $hostedSettings
        );

        /** @var \CommerceGuys\AuthNet\Response\XmlResponse $response */
        $response = $request->execute();
        $contents = $response->contents();

        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());

        $this->assertTrue(property_exists($contents, 'token'));
        $this->assertNotEmpty($contents->token);
    }

    /**
     * Tests the Accept Hosted request with JSON format.
     */
    public function testGetHostedPaymentPageJson()
    {
        // Minimal valid transaction request for Accept Hosted.
        $transactionRequest = new TransactionRequest([
            'transactionType' => TransactionRequest::AUTH_CAPTURE,
            'amount' => '20.00',
        ]);
        // Minimal hosted payment settings.
        $hostedSettings = new HostedPaymentSettings();
        $hostedSettings->addSetting(new Setting('hostedPaymentReturnOptions', [
            'showReceipt' => true,
            'url' => 'https://mysite.com/receipt',
            'urlText' => 'Continue',
            'cancelUrl' => 'https://mysite.com/cancel',
            'cancelUrlText' => 'Cancel'
        ]));

        $request = new GetHostedPaymentPageRequest(
            $this->configurationJson,
            $this->client
        );
        $request->setTransactionRequest($transactionRequest);
        $request->setHostedPaymentSettings($hostedSettings);

        /** @var \CommerceGuys\AuthNet\Response\JsonResponse $response */
        $response = $request->execute();
        $contents = $response->contents();

        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());

        $this->assertTrue(property_exists($contents, 'token'));
        $this->assertNotEmpty($contents->token);
    }
}
