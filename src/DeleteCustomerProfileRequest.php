<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\Request\RequestInterface;

class DeleteCustomerProfileRequest extends BaseApiRequest
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

    protected function attachData(RequestInterface $request)
    {
        $request->addData('customerProfileId', $this->customerProfileId);
    }
}
