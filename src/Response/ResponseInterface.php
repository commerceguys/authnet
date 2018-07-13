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
     * @return string
     */
    public function getMessageCode();

    /**
     * @return \CommerceGuys\AuthNet\DataTypes\Message[]
     */
    public function getMessages();

    /**
     * @return \CommerceGuys\AuthNet\DataTypes\Message[]
     */
    public function getErrors();

    public function __get($name);
}
