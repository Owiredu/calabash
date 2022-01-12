<?php
// declare namespace
namespace Routes;

// require controllers
require(__DIR__ . '/../controllers/UserController.php');

// use namespaces
use Controllers;

/**
 * User router
 */
class UserRouter {

    public function index() {
        Controllers\UserController::hello();
    }

}