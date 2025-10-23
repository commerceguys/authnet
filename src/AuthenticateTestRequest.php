<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\DataTypes\MerchantAuthentication;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Represents the authenticateTestRequest endpoint for testing API credentials.
 *
 * This request verifies that the provided API Login ID and Transaction Key
 * are valid and that the merchant is authorized to submit transactions.
 *
 * Commonly used to validate configuration forms or connectivity.
 *
 * @link https://developer.authorize.net/api/reference/index.html#gettingstarted-section-section-header
 */
class AuthenticateTestRequest extends BaseApiRequest
{

    /**
     * Sets the merchant authentication credentials.
     *
     * @param \CommerceGuys\AuthNet\DataTypes\MerchantAuthentication $merchantAuthentication
     *
     * @return $this
     */
    public function setMerchantAuthentication(MerchantAuthentication $merchantAuthentication): self
    {
        $this->merchantAuthentication = $merchantAuthentication;
        return $this;
    }

    /**
     * Gets the merchant authentication credentials.
     *
     * @return \CommerceGuys\AuthNet\DataTypes\MerchantAuthentication|null
     */
    public function getMerchantAuthentication(): ?MerchantAuthentication
    {
        return $this->merchantAuthentication;
    }

    /**
     * {@inheritdoc}
     */
    protected function attachData(RequestInterface $request): void
    {
        // Only attach merchant authentication if available.
        if ($this->merchantAuthentication) {
            $request->addDataType($this->merchantAuthentication);
        }
    }
}
