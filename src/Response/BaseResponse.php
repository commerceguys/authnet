<?php

namespace mglaman\AuthNet\Response;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

/**
 * Class BaseResponse
 * @package mglaman\AuthNet\Response
 */
abstract class BaseResponse implements ResponseInterface
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var object
     */
    protected $contents;

    /**
     * BaseResponse constructor.
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(HttpResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Returns the response raw data.
     *
     * @return mixed
     */
    public function contents()
    {
        return $this->contents;
    }

    public function getResultCode()
    {
        return $this->contents->messages->resultCode;
    }

    public function getMessages()
    {
        if (is_array($this->contents->messages->message)) {
            return $this->contents->messages->message;
        } else {
            return [$this->contents->messages->message];
        }
    }

    public function __isset($name)
    {
        return isset($this->contents->$name);
    }

    public function __get($name)
    {
        return $this->contents->$name;
    }
}
