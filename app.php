<?php
// require routers
include_once(__DIR__ . '/routes/UserRouter.php');
include_once(__DIR__ . '/lib/classes/RequestClass.php');
include_once(__DIR__ . '/lib/classes/RouterClass.php');

// use interfaces
use Lib\Class\Router as HTTPRouter;
use Lib\Class\Request as HTTPRequest;
use Routes\Class\UserRouter as UserRouter;

// create the router
$router = new HTTPRouter(new HTTPRequest);

// add routes
$router->get('/calabash/user', function($request) {
    return UserRouter::hello($request);
});