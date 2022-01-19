<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Lib\Core;

// require routers
require_once(__DIR__ . '/Request.php');
require_once(__DIR__ . '/Response.php');
require_once(__DIR__ . '/Router.php');

// use interfaces
use Lib\Core\Request as HTTPRequest;
use Lib\Core\Response as HTTPResponse;
use Lib\Core\Router as HTTPRouter;

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