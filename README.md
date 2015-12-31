# Corpuscle Router #
Tiny router for API-like apps build with Corpuscle Framework

Can be installed with composer

    composer require jakulov/corpuscle_router
   

## 1. Router ##
Container could be used to store any array data (e.g. configuration or repository) and easy accessing it with dot notation.

    $config = [
        '/articles' => 'ArticlesController',
    ];

    $router = new \jakulov\Corpuscle\Router\ApiRouter();
    $router->setConfig($config);
    
    $request = \Symfony\Component\HttpFoundation\Request::create('/articles', 'GET');
    $result = $router->route($request);
    echo $result->controller; // 'ArticlesController'
    echo $result->action; // 'list'
    echo $result->id; // null
    
    $request = \Symfony\Component\HttpFoundation\Request::create('/articles', 'POST');
    $result = $router->route($request);
    echo $result->controller; // 'ArticlesController'
    echo $result->action; // 'create'
    echo $result->id; // null
    
    $request = \Symfony\Component\HttpFoundation\Request::create('/articles/1', 'POST');
    $result = $router->route($request);
    echo $result->controller; // 'ArticlesController'
    echo $result->action; // 'edit'
    echo $result->id; // 1
    
    $request = \Symfony\Component\HttpFoundation\Request::create('/articles/1', 'GET');
    $result = $router->route($request);
    echo $result->controller; // 'ArticlesController'
    echo $result->action; // 'show'
    echo $result->id; // 1
    
    $request = \Symfony\Component\HttpFoundation\Request::create('/articles/1/delete', 'POST');
    $result = $router->route($request);
    echo $result->controller; // 'ArticlesController'
    echo $result->action; // 'delete'
    echo $result->id; // 1
    
    $request = \Symfony\Component\HttpFoundation\Request::create('/articles/1/comments', 'GET');
    $result = $router->route($request);
    echo $result->controller; // 'ArticlesController'
    echo $result->action; // 'comments'
    echo $result->id; // 1
    
## Tests ##

Run:
vendor/bin/phpunit tests/

Tests are also examples for usage library