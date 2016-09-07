<?php

namespace mglaman\AuthNet;

interface ApiRequestInterface
{
    /**
     * @return \mglaman\AuthNet\Response\ResponseInterface
     */
    public function execute();
}
