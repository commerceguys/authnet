<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Request\RequestInterface;
use CommerceGuys\AuthNet\DataTypes\OpaqueData;

/**
 * Use this method to decrypt the VISA Checkout data.
 *
 * @link http://developer.authorize.net/api/reference/index.html#payment-transactions-charge-a-credit-card
 */
class DecryptPaymentDataRequest extends BaseApiRequest
{
    protected $opaqueData;
    protected $refId = '';
    protected $callId = '';

    public function __construct(
        Configuration $configuration,
        Client $client,
        OpaqueData $opaqueData = null,
        $refId,
        $callId
    ) {
          parent::__construct($configuration, $client);
          $this->opaqueData = $opaqueData;
          $this->refId = $refId;
          $this->callId = $callId;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addDataType($this->opaqueData);
        $request->addData('refId', $this->refId);
        $request->addData('callId', $this->callId);
    }
}
