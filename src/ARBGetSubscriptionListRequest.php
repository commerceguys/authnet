<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\DataTypes\Paging;
use CommerceGuys\AuthNet\DataTypes\Sorting;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Use this method to get subscriptions using Automated Recurring Billing.
 */
class ARBGetSubscriptionListRequest extends ARBSubscriptionRequest
{
    protected $searchType;

    protected $sorting;

    protected $paging;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $searchType
    ) {
        parent::__construct($configuration, $client);
        $this->searchType = $searchType;
    }

    /**
     * @param \CommerceGuys\AuthNet\DataTypes\Sorting $sorting
     * @return $this
     */
    public function setSorting(Sorting $sorting)
    {
        $this->sorting = $sorting;
        return $this;
    }

    /**
     * @param \CommerceGuys\AuthNet\DataTypes\Paging $paging
     * @return $this
     */
    public function setPaging(Paging $paging)
    {
        $this->paging = $paging;
        return $this;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('searchType', $this->searchType);
        if ($this->sorting) {
            $request->addDataType($this->sorting);
        }
        if ($this->paging) {
            $request->addDataType($this->paging);
        }
    }
}
