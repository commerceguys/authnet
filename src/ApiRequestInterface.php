<?php

namespace CommerceGuys\AuthNet;

interface ApiRequestInterface
{
    /**
     * @return \CommerceGuys\AuthNet\Response\ResponseInterface
     */
    public function execute();
}
