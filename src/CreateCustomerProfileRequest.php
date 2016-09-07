<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Profile;
use CommerceGuys\AuthNet\Request\RequestInterface;

class CreateCustomerProfileRequest extends BaseApiRequest
{
    protected $profile;
    protected $validationMode = 'testMode';

    public function __construct(
        Configuration $configuration,
        Client $client,
        Profile $profile = null
    ) {
        parent::__construct($configuration, $client);
        $this->profile = $profile;
    }

    /**
     * @param \CommerceGuys\AuthNet\DataTypes\Profile $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return string
     */
    public function getValidationMode()
    {
        return $this->validationMode;
    }

    /**
     * @param string $validationMode
     */
    public function setValidationMode($validationMode)
    {
        $this->validationMode = $validationMode;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addDataType($this->profile);
        $request->addData('validationMode', $this->validationMode);
    }
}
