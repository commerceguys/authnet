<?php

namespace mglaman\AuthNet\Request;

use mglaman\AuthNet\DataTypes\DataTypeInterface;

/**
 * Interface AuthNetRequestInterface
 * @package mglaman\AuthNet\Request
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
     * @todo move to interface
     * @param $name
     * @param $value
     */
    public function addData($name, $value);

    /**
     * @return \mglaman\AuthNet\Response\ResponseInterface
     * @throws \mglaman\AuthNet\Exception\AuthNetException
     */
    public function sendRequest();
}
