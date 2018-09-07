<?php

namespace CommerceGuys\AuthNet;

use GuzzleHttp\Client;
use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Updates a held transaction.
 *
 * @link https://developer.authorize.net/api/reference/index.html#fraud-management-approve-or-decline-held-transaction
 */
class UpdateHeldTransactionRequest extends BaseApiRequest
{
    const APPROVE = 'approve';
    const DECLINE = 'decline';

    protected $action;
    protected $refTransId;

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setRefTransId($refTransId)
    {
        $this->refTransId = $refTransId;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addData('heldTransactionRequest', [
            'action' => $this->action,
            'refTransId' => $this->refTransId,
        ]);
    }
}
