<?php

namespace CommerceGuys\AuthNet\Request;

class JsonRequest extends BaseRequest
{
    public function getContentType()
    {
        return 'application/json';
    }

    public function getBody()
    {
        return json_encode([$this->type => $this->data]);
    }
}
