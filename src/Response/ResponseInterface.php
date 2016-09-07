<?php

namespace CommerceGuys\AuthNet\Response;

interface ResponseInterface
{
    /**
     * Returns the response raw data.
     *
     * @return mixed
     */
    public function contents();

    /**
     * @return string
     */
    public function getResultCode();

    /**
     * @return \CommerceGuys\AuthNet\DataTypes\Message[]
     */
    public function getMessages();

    public function __get($name);
}
