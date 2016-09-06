<?php

namespace mglaman\AuthNet;

use GuzzleHttp\Client;
use mglaman\AuthNet\DataTypes\Profile;
use mglaman\AuthNet\Request\RequestInterface;

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
     * @param \mglaman\AuthNet\DataTypes\Profile $profile
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
