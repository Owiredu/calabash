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

    public static function hello($request, $response) {
        UserController::hello($request, $response);
    }

    public static function login($request, $response) {
        UserController::login($request, $response);
    }

}