<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Profile;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Update an existing customer profile.
 *
 * @link http://developer.authorize.net/api/reference/index.html#customer-profiles-update-customer-profile
 */
class UpdateCustomerProfileRequest extends BaseApiRequest
{
    protected $profile;

    public function __construct(
        Configuration $configuration,
        Client $client,
        Profile $profile = null
    ) {
        parent::__construct($configuration, $client);
        $this->profile = $profile;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addDataType($this->profile);
    }
}
