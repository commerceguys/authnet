<?php

namespace mglaman\AuthNet\Response;

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
     * @return \mglaman\AuthNet\DataTypes\Message[]
     */
    public function getMessages();

    public function __get($name);
}
