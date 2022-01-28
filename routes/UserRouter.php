<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Router;

// require modules
require_once(__DIR__ . '/../controllers/UserController.php');


// use namespaces
use Controller\UserController as UserController;

/**
 * User router
 */
class UserRouter {

    /**
     * Holds all an array of the subroutes and their corresponding callbacks for ```GET``` requests
     */
    public static $GET = [
        "/message" => [UserController::class, "hello"],
        "/info" => [UserController::class, "info"],
        "/:id/:param/dyn" => [UserController::class, "dynamic_route"]
    ];

    /**
     * Holds all an array of the subroutes and their corresponding callbacks for ```POST``` requests
     */
    public static $POST = [
        "/login" => [UserController::class, "login"]
    ];

}