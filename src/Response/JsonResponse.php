<?php

namespace CommerceGuys\AuthNet\Response;

use CommerceGuys\AuthNet\Exception\AuthNetException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class JsonResponse extends BaseResponse
{

    public function __construct(HttpResponseInterface $response)
    {
        parent::__construct($response);
        $content = $response->getBody()->getContents();
        // The API returns hidden Byte Order Mark characters, causing the
        // JSON decoding to fail.
        $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
        $content = json_decode($content);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AuthNetException(sprintf("JSON returned from API was not decoded: %s", json_last_error_msg()));
        }
        $this->contents = $content;
    }
}
