<?php

namespace mglaman\AuthNet\Tests;

use mglaman\AuthNet\CreateCustomerPaymentProfileRequest;
use mglaman\AuthNet\CreateCustomerProfileRequest;
use mglaman\AuthNet\DataTypes\BillTo;
use mglaman\AuthNet\DataTypes\CreditCard;
use mglaman\AuthNet\DataTypes\PaymentProfile;
use mglaman\AuthNet\DataTypes\Profile;
use mglaman\AuthNet\DeleteCustomerPaymentProfileRequest;
use mglaman\AuthNet\GetCustomerPaymentProfileRequest;
use mglaman\AuthNet\ValidateCustomerPaymentProfileRequest;

class CustomerPaymentProfileRequestTest extends TestBase
{

    public function testCreateCustomerPaymentProfile()
    {
        $profile = new Profile([
          'email' => 'example+' . rand(0, 10000) . '@example.com',
        ]);
        $request = new CreateCustomerProfileRequest($this->configuration, $this->client);
        $request->setProfile($profile);
        $request->setValidationMode('none');
        $response = $request->execute();

        $customerProfileId = $response->customerProfileId;

        $request = new CreateCustomerPaymentProfileRequest($this->configuration, $this->client);
        $request->setCustomerProfileId($customerProfileId);

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

        $request->setPaymentProfile($paymentProfile);

        $response = $request->execute();
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
        $this->assertEquals('Ok', $response->getResultCode());
        $this->assertTrue(isset($response->customerPaymentProfileId));

        $customerPaymentProfileId = $response->customerPaymentProfileId;

        $request = new GetCustomerPaymentProfileRequest($this->configuration, $this->client);
        $request->setCustomerProfileId($customerProfileId);
        $request->setCustomerPaymentProfileId($customerPaymentProfileId);
        $response = $request->execute();
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());

        $request = new ValidateCustomerPaymentProfileRequest($this->configuration, $this->client);
        $request->setCustomerProfileId($customerProfileId);
        $request->setCustomerPaymentProfileId($customerPaymentProfileId);
        $response = $request->execute();
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());

        $request = new DeleteCustomerPaymentProfileRequest($this->configuration, $this->client);
        $request->setCustomerProfileId($customerProfileId);
        $request->setCustomerPaymentProfileId($customerPaymentProfileId);
        $response = $request->execute();
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());

        $request = new GetCustomerPaymentProfileRequest($this->configuration, $this->client);
        $request->setCustomerProfileId($customerProfileId);
        $request->setCustomerPaymentProfileId($customerPaymentProfileId);
        $response = $request->execute();
        $this->assertEquals('E00040', $response->getMessages()[0]->getCode());
        $this->assertEquals('The record cannot be found.', $response->getMessages()[0]->getText());
    }
}