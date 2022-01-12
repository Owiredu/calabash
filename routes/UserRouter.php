<?php
// declare namespace
namespace Routes;

// require controllers
require(__DIR__ . '../controllers/UserController');

// use namespaces
use Controllers;

/**
 * User router
 */
class UserRouter {

    public function index() {
        return Controllers\UserController::index();
    }

}