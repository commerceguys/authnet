<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\Request\RequestInterface;

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
