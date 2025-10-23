<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Retrieve an existing customer profile.
 *
 * @link http://developer.authorize.net/api/reference/index.html#customer-profiles-get-customer-profile
 */
class GetCustomerProfileRequest extends BaseApiRequest
{
    protected $customerProfileId;
    protected $unmaskExpirationDate = false;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $customerProfileId
    ) {
        parent::__construct($configuration, $client);
        $this->customerProfileId = $customerProfileId;
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
        if ($this->unmaskExpirationDate) {
            $request->addData('unmaskExpirationDate', $this->unmaskExpirationDate);
        }
    }
}
