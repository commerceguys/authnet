<?php

namespace CommerceGuys\AuthNet\Request;

use CommerceGuys\AuthNet\DataTypes\DataTypeInterface;

/**
 * Interface AuthNetRequestInterface
 * @package CommerceGuys\AuthNet\Request
 */
interface RequestInterface
{
    /**
     * Get the request's Content-Type header value.
     * @return string
     */
    public function getContentType();

    /**
     * Gets the request's body payload.
     *
     * @return string
     */
    public function getBody();

    public function addDataType(DataTypeInterface $data);

    /**
     * @param $name
     * @param $value
     */
    public function addData($name, $value);

    /**
     * @return \CommerceGuys\AuthNet\Response\ResponseInterface
     * @throws \CommerceGuys\AuthNet\Exception\AuthNetException
     */
    public function sendRequest();
}
