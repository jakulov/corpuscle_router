<?php
namespace jakulov\Corpuscle\Router;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiRouter
 * @package jakulov\Corpuscle\Router
 */
class ApiRouter implements RouterInterface
{
    /** @var array */
    protected $config = [];

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @return RouteResult
     */
    public function route(Request $request) : RouteResult
    {
        $path = trim($request->getPathInfo(), '/');
        $pathParts = explode('/', $path);
        $basePath = strtolower('/' . $pathParts[0]);

        return $this->createRouteResult(
            $request->getMethod(), $pathParts, isset($this->config[$basePath]) ? $this->config[$basePath]: null
        );
    }

    /**
     * @param string $method
     * @param array $pathParts
     * @param null $controller
     * @return RouteResult
     */
    protected function createRouteResult($method, array $pathParts, $controller = null)
    {
        $routeResult = new RouteResult();
        if(
            $controller === null ||
            count($pathParts) > 3 ||
            !in_array($method, ['GET', 'POST', true])
        ) {
            return $routeResult;
        }

        $id = null;
        $action = RouteResult::ACTION_LIST;
        if(isset($pathParts[1])) {
            $id = $pathParts[1];
            $action = RouteResult::ACTION_SHOW;
        }

        if(isset($pathParts[2])) {
            $action = $pathParts[2];
            if($action === RouteResult::ACTION_DELETE && $method !== 'POST') {
                return $routeResult;
            }
            elseif($action !== RouteResult::ACTION_DELETE && $method === 'POST') {
                return $routeResult;
            }
        }
        elseif ($method === 'POST') {
            $action = $id === null ? RouteResult::ACTION_CREATE : RouteResult::ACTION_EDIT;
        }

        $routeResult->controller = $controller;
        $routeResult->action = $action;
        $routeResult->id = $id;

        return $routeResult;
    }
}