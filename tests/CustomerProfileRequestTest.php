<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\CreateCustomerProfileRequest;
use CommerceGuys\AuthNet\DataTypes\BillTo;
use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\PaymentProfile;
use CommerceGuys\AuthNet\DataTypes\Profile;
use CommerceGuys\AuthNet\DeleteCustomerProfileRequest;
use CommerceGuys\AuthNet\GetCustomerProfileIdsRequest;
use CommerceGuys\AuthNet\GetCustomerProfileRequest;
use CommerceGuys\AuthNet\UpdateCustomerProfileRequest;

class CustomerProfileRequestTest extends TestBase
{

    public function testGetCustomerProfileIdsRequest()
    {
        $request = new GetCustomerProfileIdsRequest($this->configurationXml, $this->client);
        $response = $request->execute();
        $this->assertTrue(isset($response->ids));
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
    }

    public function testCreateCustomerProfileCRUDRequests()
    {
        $paymentProfile = new PaymentProfile([
          'customerType' => 'individual',
        ]);
        // @note: You must add the billTo first.
        $paymentProfile->addBillTo(new BillTo([
          'firstName' => 'Johnny',
          'lastName' => 'Appleseed',
          'address' => '1234 New York Drive',
          'city' => 'New York City',
          'state' => 'NY',
          'zip' => '12345',
          'country' => 'US',
          'phoneNumber' => '5555555555',
        ]));
        $paymentProfile->addPayment(new CreditCard([
          'cardNumber' => '4111111111111111',
          'expirationDate' => '2020-12',
        ]));

        $profile = new Profile([
          'email' => 'example+' . mt_rand() . '@example.com',
        ]);
        $profile->addPaymentProfile($paymentProfile);

        $request = new CreateCustomerProfileRequest($this->configurationXml, $this->client);
        $request->setProfile($profile);
        $response = $request->execute();
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
        $this->assertTrue(isset($response->customerProfileId));
        $this->assertTrue(isset($response->customerPaymentProfileIdList));
        $this->assertTrue(isset($response->validationDirectResponseList));

        $request = new GetCustomerProfileRequest($this->configurationXml, $this->client, $response->customerProfileId);
        $response = $request->execute();
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
        $this->assertTrue(isset($response->profile));

        $customerProfileId = $response->profile->customerProfileId;
        $profile = new Profile([
            'email' => 'exampleUpdated+' . rand(0, 10000) . '@example.com',
            'customerProfileId' => $customerProfileId,
        ]);
        $request = new UpdateCustomerProfileRequest($this->configurationXml, $this->client, $profile);
        $response = $request->execute();
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');

        $request = new DeleteCustomerProfileRequest(
            $this->configurationXml,
            $this->client,
            $customerProfileId
        );
        $response = $request->execute();
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');

    }
}
