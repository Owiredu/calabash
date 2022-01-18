<?php
// declare namespace
namespace Lib\Core\Class;

// require routers
require_once(__DIR__ . '/RequestClass.php');
require_once(__DIR__ . '/ResponseClass.php');
require_once(__DIR__ . '/RouterClass.php');

// use interfaces
use Lib\Core\Class\Request as HTTPRequest;
use Lib\Core\Class\Response as HTTPResponse;
use Lib\Core\Class\Router as HTTPRouter;

/**
 * Calabash main app
 */
class Calabash {
    /**
     * The main router for the application
     * @var HTTPRouter
     */
    private HTTPRouter $router;

    function __construct()
    {
        // initialize the application router with request and response objects
        $this->router = new HTTPRouter(new HTTPRequest, new HTTPResponse);
    }

    /**
     * Adds a router to the application.
     * @param string $base_path The router class' base path
     * @param class $router_class The router class. eg. IndexRouter::class, UserRouter::class
     */
    public function add_router(string $base_path, $router_class) {
        // add router
        $this->router->add($base_path, $router_class);
    }
}