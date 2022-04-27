<?php

namespace PHPMaker2022\juzmatch;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * investorReceiveMonthly controller
 */
class InvestorReceiveMonthlyController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InvestorReceiveMonthly");
    }
}
