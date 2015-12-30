<?php
namespace jakulov\Corpuscle\Router;

/**
 * Class RouteResult
 * @package jakulov\Corpuscle\Router
 */
class RouteResult
{
    public $controller;
    public $action;
    public $id;

    /**
     * @return bool
     */
    public function isNotFound()
    {
        return $this->controller === null;
    }
}