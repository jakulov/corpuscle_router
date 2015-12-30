<?php
namespace jakulov\Corpuscle\Router;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RouterInterface
 * @package jakulov\Corpuscle\Router
 */
interface RouterInterface
{
    /**
     * @param Request $request
     * @return RouteResult
     */
    public function route(Request $request) : RouteResult;
}