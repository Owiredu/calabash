<?php
// require routers
include_once(__DIR__ . '/lib/classes/RequestClass.php');
include_once(__DIR__ . '/lib/classes/ResponseClass.php');
include_once(__DIR__ . '/lib/classes/RouterClass.php');
include_once(__DIR__ . '/routes/UserRouter.php');

// use interfaces
use Lib\Class\Router as HTTPRouter;
use Lib\Class\Request as HTTPRequest;
use Lib\Class\Response as HTTPResponse;
use Routers\UserRouter as UserRouter;

// create the router
$router = new HTTPRouter(new HTTPRequest, new HTTPResponse);

// add routes

// using static method as callback
$router->get('/calabash/user', [UserRouter::class, 'hello']); 

// using anonymous function as callback
$router->post('/calabash/login', function($request, $response) {
    UserRouter::login($request, $response);
});