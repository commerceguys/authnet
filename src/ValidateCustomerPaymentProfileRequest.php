<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Verifies an existing customer payment profile.
 *
 * @link http://developer.authorize.net/api/reference/index.html#customer-profiles-validate-customer-payment-profile
 */
class ValidateCustomerPaymentProfileRequest extends BaseApiRequest
{
    protected $customerProfileId;
    protected $customerPaymentProfileId;
    protected $customerShippingAddressId;
    protected $cardCode;
    protected $validationMode = 'testMode';

    /**
     * @param mixed $customerProfileId
     */
    public function setCustomerProfileId($customerProfileId)
    {
        $this->customerProfileId = $customerProfileId;
    }

    /**
     * @param mixed $customerPaymentProfileId
     */
    public function setCustomerPaymentProfileId($customerPaymentProfileId)
    {
        $this->customerPaymentProfileId = $customerPaymentProfileId;
    }

    /**
     * @param mixed $customerShippingAddressId
     */
    public function setCustomerShippingAddressId($customerShippingAddressId)
    {
        $this->customerShippingAddressId = $customerShippingAddressId;
    }

    /**
     * @param mixed $cardCode
     */
    public function setCardCode($cardCode)
    {
        $this->cardCode = $cardCode;
    }

    public function setValidationMode($validationMode)
    {
        $this->validationMode = $validationMode;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('customerProfileId', $this->customerProfileId);
        $request->addData('customerPaymentProfileId', $this->customerPaymentProfileId);

        if (isset($this->customerShippingAddressId)) {
            $request->addData('customerShippingAddressId', $this->customerShippingAddressId);
        }
        if (isset($this->cardCode)) {
            $request->addData('cardCode', $this->cardCode);
        }
        $request->addData('validationMode', $this->validationMode);
    }
}
