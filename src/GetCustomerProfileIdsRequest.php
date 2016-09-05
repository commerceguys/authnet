<?php

namespace mglaman\AuthNet;

class GetCustomerProfileIdsRequest extends BaseApiRequest
{

    public function execute()
    {
        $request = $this->preparedRequest();
        $response = $request->sendRequest();
        return $response;
    }
}
