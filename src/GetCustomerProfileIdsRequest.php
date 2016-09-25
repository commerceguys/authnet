<?php

namespace CommerceGuys\AuthNet;

use CommerceGuys\AuthNet\Request\RequestInterface;

/**
 * Retrieve all existing customer profile IDs.
 *
 * @link http://developer.authorize.net/api/reference/index.html#customer-profiles-get-customer-profile-ids
 */
class GetCustomerProfileIdsRequest extends BaseApiRequest
{
    protected function attachData(RequestInterface $request)
    {
        // TODO: Implement attachData() method.
    }
}
