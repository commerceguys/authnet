<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Retrieve a customer payment profile for an existing customer profile.
 *
 * @link http://developer.authorize.net/api/reference/index.html#customer-profiles-get-customer-payment-profile
 */
class GetCustomerPaymentProfileRequest extends BaseApiRequest
{
    protected $customerProfileId;
    protected $customerPaymentProfileId;
    protected $unmaskExpirationDate = false;

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
     * @param boolean $unmaskExpirationDate
     */
    public function setUnmaskExpirationDate($unmaskExpirationDate)
    {
        $this->unmaskExpirationDate = $unmaskExpirationDate;
    }



    protected function attachData(RequestInterface $request)
    {
        $request->addData('customerProfileId', $this->customerProfileId);
        $request->addData('customerPaymentProfileId', $this->customerPaymentProfileId);
        if ($this->unmaskExpirationDate) {
            $request->addData('unmaskExpirationDate', $this->unmaskExpirationDate);
        }
    }
}
