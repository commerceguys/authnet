<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\DataTypes\Profile;
use mglaman\AuthNet\Request\RequestInterface;

/**
 * Class UpdateCustomerProfileRequest
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
