<?php

namespace mglaman\AuthNet\Tests;

use GuzzleHttp\Client;
use mglaman\AuthNet\Configuration;
use mglaman\AuthNet\CreateCustomerProfileRequest;
use mglaman\AuthNet\DataTypes\Profile;
use mglaman\AuthNet\DeleteCustomerProfileRequest;
use mglaman\AuthNet\GetCustomerProfileIdsRequest;
use mglaman\AuthNet\GetCustomerProfileRequest;
use mglaman\AuthNet\UpdateCustomerProfileRequest;

class CustomerProfileRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \mglaman\AuthNet\Configuration
     */
    protected $configuration;
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->configuration = new Configuration([
          'api_login' => AUTHORIZENET_API_LOGIN_ID,
          'transaction_key' => AUTHORIZENET_TRANSACTION_KEY,
          'sandbox' => true,
        ]);
        $this->client = new Client();
    }

    public function testGetCustomerProfileIdsRequest()
    {
        $request = new GetCustomerProfileIdsRequest($this->configuration, $this->client);
        $response = $request->execute();
        $this->assertTrue(isset($response->ids));
        $this->assertEquals('I00001', $response->getMessages()[0]->code);
        $this->assertEquals('Successful.', $response->getMessages()[0]->text);
        $this->assertEquals('Ok', $response->getResultCode());
    }

    public function testCreateCustomerProfileCRUDRequests()
    {
        $request = new CreateCustomerProfileRequest($this->configuration, $this->client);
        $request->setProfile(new Profile([
          'email' => 'example+' . rand(0, 10000) . '@example.com',
          'paymentProfiles' => [
            'customerType' => 'individual',
            'payment' => [
              'creditCard' => [
                'cardNumber' => '4111111111111111',
                'expirationDate' => '2020-12',
              ],
            ],
          ],
        ]));
        $response = $request->execute();
        $this->assertTrue(isset($response->customerProfileId));

        $request = new GetCustomerProfileRequest($this->configuration, $this->client, $response->customerProfileId);
        $response = $request->execute();
        $this->assertEquals('I00001', $response->getMessages()[0]->code);
        $this->assertEquals('Successful.', $response->getMessages()[0]->text);
        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertTrue(isset($response->profile));

        $customerProfileId = $response->profile->customerProfileId;
        $profile = new Profile([
            'email' => 'exampleUpdated+' . rand(0, 10000) . '@example.com',
            'customerProfileId' => $customerProfileId,
        ]);
        $request = new UpdateCustomerProfileRequest($this->configuration, $this->client, $profile);
        $response = $request->execute();
        $this->assertEquals('I00001', $response->getMessages()[0]->code);
        $this->assertEquals('Successful.', $response->getMessages()[0]->text);
        $this->assertEquals('Ok', $response->getResultCode());

        $request = new DeleteCustomerProfileRequest(
            $this->configuration,
            $this->client,
          $customerProfileId
        );
        $response = $request->execute();
        $this->assertEquals('I00001', $response->getMessages()[0]->code);
        $this->assertEquals('Successful.', $response->getMessages()[0]->text);
        $this->assertEquals('Ok', $response->getResultCode());

    }
}
