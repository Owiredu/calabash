<?php
// declare namespace
namespace Controllers;

// require modules
include_once(__DIR__ . '/../models/UserModel.php');

// User controller
class UserController {

    public static function hello($request, $response) {
        // send response
        $response->render('index.html.twig', ['name' => "Nana Kofi"]);
    }

    public static function login($request, $response) {
        // send response
        $response->json(["message" => "Login successful"]);
    }

}