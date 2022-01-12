<?php
// declare namespace
namespace Controllers;

// require models
require(__DIR__ . '../models/UserModel');

// use namespaces
use Models;

// User controller
class UserController {

    public static function index() {
        return "Hello world";
    }

}