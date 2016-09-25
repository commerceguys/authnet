<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Delete a customer payment profile from an existing customer profile.
 *
 * @link http://developer.authorize.net/api/reference/index.html#customer-profiles-delete-customer-payment-profile
 */
class DeleteCustomerPaymentProfileRequest extends BaseApiRequest
{
    protected $customerProfileId;
    protected $customerPaymentProfileId;

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

    protected function attachData(RequestInterface $request)
    {
        $request->addData('customerProfileId', $this->customerProfileId);
        $request->addData('customerPaymentProfileId', $this->customerPaymentProfileId);
    }
}
