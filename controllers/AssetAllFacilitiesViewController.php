<?php

namespace PHPMaker2022\juzmatch;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AssetAllFacilitiesViewController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        $args = $this->getKeyParams($args);
        return $this->runPage($request, $response, $args, "AssetAllFacilitiesViewList");
    }

    protected function getKeyParams($args)
    {
        $sep = Container("asset_all_facilities_view")->RouteCompositeKeySeparator;
        if (array_key_exists("keys", $args)) {
            $keys = explode($sep, $args["keys"]);
            return count($keys) == 2 ? array_combine(["master_facilities_group_id","master_facilities_id"], $keys) : $args;
        }
        return $args;
    }
}
