<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\DataTypes\HostedPaymentSettings;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;
use CommerceGuys\AuthNet\Request\RequestInterface;
use GuzzleHttp\Client;

/**
 * Retrieves a token to launch the Accept Hosted payment form.
 *
 * @link https://developer.authorize.net/api/reference/index.html#accept-suite-get-an-accept-payment-page
 */
class GetHostedPaymentPageRequest extends BaseApiRequest
{
    /**
     * @var \CommerceGuys\AuthNet\DataTypes\TransactionRequest|null
     */
    protected $transactionRequest;

    /**
     * @var \CommerceGuys\AuthNet\DataTypes\HostedPaymentSettings|null;
     */
    protected $hostedPaymentSettings;

    /**
     * Constructs a new GetHostedPaymentPageRequest object.
     *
     * @param Configuration $configuration
     *   The configuration object containing API credentials.
     * @param Client $client
     *   The HTTP client for making requests.
     * @param \CommerceGuys\AuthNet\DataTypes\TransactionRequest|null $transactionRequest
     *   The transaction request details.
     * @param \CommerceGuys\AuthNet\DataTypes\HostedPaymentSettings|null $hostedPaymentSettings
     *   The settings for the Accept Hosted payment form.
     */
    public function __construct(
        Configuration $configuration,
        Client $client,
        TransactionRequest $transactionRequest = null,
        HostedPaymentSettings $hostedPaymentSettings = null
    ) {
        parent::__construct($configuration, $client);
        $this->transactionRequest = $transactionRequest;
        $this->hostedPaymentSettings = $hostedPaymentSettings;
    }

    /**
     * {@inheritdoc}
     */
    protected function attachData(RequestInterface $request)
    {
        // Attach transaction details.
        if ($this->transactionRequest) {
            $request->addDataType($this->transactionRequest);
        }
        // Add hosted payment settings.
        if ($this->hostedPaymentSettings) {
            $request->addDataType($this->hostedPaymentSettings);
        }
    }

    /**
     * Sets the transaction request.
     *
     * @param \CommerceGuys\AuthNet\DataTypes\TransactionRequest $transactionRequest
     *   The transaction details.
     *
     * @return $this
     */
    public function setTransactionRequest(TransactionRequest $transactionRequest)
    {
        $this->transactionRequest = $transactionRequest;
        return $this;
    }

    /**
     * Sets the hosted payment settings.
     *
     * @param \CommerceGuys\AuthNet\DataTypes\HostedPaymentSettings $hostedPaymentSettings
     *
     * @return $this
     */
    public function setHostedPaymentSettings(HostedPaymentSettings $hostedPaymentSettings)
    {
        $this->hostedPaymentSettings = $hostedPaymentSettings;
        return $this;
    }
}
