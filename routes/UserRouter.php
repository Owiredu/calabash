<?php
// declare namespace
namespace Routers;

// require modules
require_once(__DIR__ . '/../controllers/UserController.php');


// use namespaces
use Controllers\UserController as UserController;

/**
 * User router
 */
class UserRouter {

    /**
     * Holds all an array of the subroutes and their corresponding callbacks for ```GET``` requests
     */
    public static $GET = [
        "/message" => [UserController::class, "hello"],
        "/info" => [UserController::class, "info"]
    ];

    /**
     * Holds all an array of the subroutes and their corresponding callbacks for ```POST``` requests
     */
    public static $POST = [
        "/login" => [UserController::class, "login"]
    ];

}