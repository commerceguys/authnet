<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;

class GetCustomerProfileRequest extends BaseApiRequest
{
    protected $customerProfileId;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $customerProfileId
    ) {
        parent::__construct($configuration, $client);
        $this->customerProfileId = $customerProfileId;
    }


    public function execute()
    {
        $request = $this->preparedRequest();
        $request->addData('customerProfileId', $this->customerProfileId);
        $response = $request->sendRequest();
        return $response;
    }
}
