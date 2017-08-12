<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\DataTypes\PaymentProfile;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Update an existing customer payment profile.
 *
 * @link http://developer.authorize.net/api/reference/index.html#customer-profiles-update-customer-payment-profile
 */
class UpdateCustomerPaymentProfileRequest extends BaseApiRequest
{

    /**
     * @var \CommerceGuys\AuthNet\DataTypes\PaymentProfile
     */
    protected $paymentProfile;

    protected $customerProfileId;

    protected $validationMode = 'testMode';

    public function setPaymentProfile(PaymentProfile $profile)
    {
        $this->paymentProfile = $profile;
    }

    public function setCustomerProfileId($id)
    {
        $this->customerProfileId = $id;
    }

    public function setValidationMode($validationMode)
    {
        $this->validationMode = $validationMode;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('customerProfileId', $this->customerProfileId);
        $request->addDataType($this->paymentProfile);
        $request->addData('validationMode', $this->validationMode);
    }
}
