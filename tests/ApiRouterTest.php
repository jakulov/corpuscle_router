<?php

/**
 * Created by PhpStorm.
 * User: yakov
 * Date: 30.12.15
 * Time: 23:21
 */
class ApiRouterTest extends PHPUnit_Framework_TestCase
{

    public function testRouteGet()
    {
        $config = [
            '/foo' => 'TestController',
        ];

        $urls = [
            '/foo',
            '/foo/123',
            '/foo/123/subfoo',
            '/foo/123/subfoo?filter=blabla&sort=-updatedAt',
            '/',
        ];

        $router = new \jakulov\Corpuscle\Router\ApiRouter();
        $router->setConfig($config);

        foreach($urls as $url) {
            $uriParts = explode('?', $url);
            $pathParts = array_values(array_filter(explode('/', $uriParts[0])));
            parse_str(isset($uriParts[1]) ? $uriParts[1] : '', $params);
            $request = \Symfony\Component\HttpFoundation\Request::create(
                $uriParts[0], 'GET', $params);

            $result = $router->route($request);

            $controller = null;
            $id = isset($pathParts[1]) ? $pathParts[1] : null;
            $action = isset($pathParts[2]) ? $pathParts[2] : ($id !== null ? 'show' : 'list');

            if($url !== '/') {
                $controller = 'TestController';
            }
            else {
                $action = null;
            }
            if(count($pathParts) > 3) {
                $controller = null;
                $action = null;
                $id = null;
            }

            $this->assertEquals($controller, $result->controller, 'Testing url: GET '. $url);
            $this->assertEquals($action, $result->action, 'Testing url: GET '. $url);
            $this->assertEquals($id, $result->id, 'Testing url: GET '. $url);
        }
    }

    public function testRouterPost()
    {
        $config = [
            '/foo' => 'TestController',
        ];

        $urls = [
            '/foo',
            '/foo/123',
            '/foo/123/subfoo',
            '/foo/123/subfoo?filter=blabla&sort=-updatedAt',
            '/',
        ];

        $router = new \jakulov\Corpuscle\Router\ApiRouter();
        $router->setConfig($config);

        foreach($urls as $url) {
            $uriParts = explode('?', $url);
            $pathParts = array_values(array_filter(explode('/', $uriParts[0])));
            $request = \Symfony\Component\HttpFoundation\Request::create(
                $uriParts[0], 'POST', ['foo' => 'bar']);

            $result = $router->route($request);

            $controller = null;
            $id = isset($pathParts[1]) ? $pathParts[1] : null;
            $action = isset($pathParts[2]) ? $pathParts[2] : ($id !== null ? 'edit' : 'create');
            if($url !== '/') {
                $controller = 'TestController';
            }
            else {
                $action = null;
            }

            if(count($pathParts) > 2) {
                $controller = null;
                $action = null;
                $id = null;
            }

            $this->assertEquals($controller, $result->controller, 'Testing url: POST '. $url);
            $this->assertEquals($action, $result->action, 'Testing url: POST '. $url);
            $this->assertEquals($id, $result->id, 'Testing url: POST '. $url);
        }

        $request = \Symfony\Component\HttpFoundation\Request::create('/any/any/url', 'PUT', ['data' => 'foo']);
        $result = $router->route($request);
        $this->assertEquals(true, $result->isNotFound());
    }

    public function testRouteDelete()
    {
        $config = [
            '/object' => 'ObjectController',
        ];

        $router = new \jakulov\Corpuscle\Router\ApiRouter();
        $router->setConfig($config);

        $request = \Symfony\Component\HttpFoundation\Request::create('/object/id/delete', 'GET', ['data' => 'foo']);
        $result = $router->route($request);
        $this->assertEquals(true, $result->isNotFound());

        $request = \Symfony\Component\HttpFoundation\Request::create('/object/id/delete', 'POST', ['data' => 'foo']);
        $result = $router->route($request);
        $this->assertEquals('ObjectController', $result->controller, 'Testing Controller DELETE action');
        $this->assertEquals('delete', $result->action, 'Testing ACTION DELETE action');
        $this->assertEquals('id', $result->id, 'Testing ID DELETE action');
    }


}
