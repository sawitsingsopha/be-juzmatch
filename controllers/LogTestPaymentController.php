<?php

namespace PHPMaker2022\juzmatch;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LogTestPaymentController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LogTestPaymentList");
    }

    // add
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LogTestPaymentAdd");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LogTestPaymentView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LogTestPaymentEdit");
    }

    // delete
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LogTestPaymentDelete");
    }
}
