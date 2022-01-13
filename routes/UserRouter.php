<?php
// declare namespace
namespace Routes\Class;

// require modules
include_once(__DIR__ . '/../controllers/UserController.php');

/**
 * User router
 */
class UserRouter {

    public static function main() {

    }

    public static function hello($request) {
        return \Controllers\UserController::hello();
    }

}