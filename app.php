<?php
// require routers
require_once(__DIR__ . '/lib/core/RequestClass.php');
require_once(__DIR__ . '/lib/core/ResponseClass.php');
require_once(__DIR__ . '/lib/core/RouterClass.php');
require_once(__DIR__ . '/routes/UserRouter.php');

// use interfaces
use Lib\Core\Class\Request as HTTPRequest;
use Lib\Core\Class\Response as HTTPResponse;
use Lib\Core\Class\Router as HTTPRouter;
use Routers\UserRouter as UserRouter;

// create the router
$router = new HTTPRouter(new HTTPRequest, new HTTPResponse);

// add routes
$router->add('/calabash/user', UserRouter::class);