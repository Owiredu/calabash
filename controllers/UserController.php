<?php
// set strict types
declare(strict_types=1);

// declare namespace
namespace Controller;

// require modules
require_once(__DIR__ . '/../models/UserModel.php');

// User controller
class UserController {

    public static function hello($request, $response) {
        // send response
        $response->render('index.html', ['name' => "Nana Kofi"]);
    }

    public static function info($request, $response) {
        // send response
        $response->render('index.html', ['name' => "Nana Kofi. This is the info response"]);
    }

    public static function login($request, $response) {
        // send response
        $response->json(["message" => "Login successful"]);
    }

}