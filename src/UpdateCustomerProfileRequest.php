<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\DataTypes\Profile;

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

    public function execute()
    {
        $request = $this->preparedRequest();
        $request->addDataType($this->profile);
        $response = $request->sendRequest();
        return $response;
    }
}
