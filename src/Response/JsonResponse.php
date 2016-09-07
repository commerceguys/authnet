<?php

namespace CommerceGuys\AuthNet\Response;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class JsonResponse extends BaseResponse
{

    public function __construct(HttpResponseInterface $response)
    {
        parent::__construct($response);
        $this->contents = json_decode($this->response->getBody()->getContents());
    }

    public function getResultCode()
    {
        return $this->contents->messages->resultCode;
    }

    public function getMessages()
    {
        return $this->contents->messages->message;
    }
}
