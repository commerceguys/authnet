<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Retrieve detailed information about a specific transaction.
 *
 * @link https://developer.authorize.net/api/reference/index.html#transaction-reporting-get-settled-batch-list
 */
class GetSettledBatchListRequest extends BaseApiRequest
{

  protected $includeStatistics;

  protected $firstSettlementDate;

  protected $lastSettlementDate;

    public function __construct(
        Configuration $configuration,
        Client $client,
        $includeStatistics,
        $firstSettlementDate,
        $lastSettlementDate
    ) {
        parent::__construct($configuration, $client);
        $this->includeStatistics = $includeStatistics;
        $this->firstSettlementDate = $firstSettlementDate;
        $this->lastSettlementDate = $lastSettlementDate;
    }

    protected function attachData(RequestInterface $request)
    {
        if ($this->includeStatistics) {
            $request->addData('includeStatistics', $this->includeStatistics);
        }
        $request->addData('firstSettlementDate', $this->firstSettlementDate);
        $request->addData('lastSettlementDate', $this->lastSettlementDate);
    }
}
