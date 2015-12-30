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

    const ACTION_LIST = 'list';
    const ACTION_SHOW = 'show';
    const ACTION_CREATE = 'create';
    const ACTION_EDIT = 'edit';
    const ACTION_DELETE = 'delete';

    /**
     * @return bool
     */
    public function isNotFound()
    {
        return $this->controller === null;
    }
}