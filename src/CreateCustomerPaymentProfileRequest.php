<?php

namespace mglaman\AuthNet;

use mglaman\AuthNet\DataTypes\PaymentProfile;
use mglaman\AuthNet\Request\RequestInterface;

class CreateCustomerPaymentProfileRequest extends BaseApiRequest
{
    /**
     * @var \mglaman\AuthNet\DataTypes\PaymentProfile
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
