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
        // var_dump($request->body());
        // var_dump($request->params());
        $response->render('index.html', ['name' => "Nana Kofi"]);
        // $response->redirect("calabash/user/info");
    }

    public static function info($request, $response) {
        // send response
        // var_dump($request->body());
        // var_dump($request->params());
        $response->render('index.html', ['name' => "Nana Kofi. This is the info response"]);
    }

    public static function login($request, $response) {
        // send response
        // var_dump($request->body());
        // var_dump($request->params());
        // var_dump($request->files());
        $request->set_session_value("test_name", "sheep in skin");
        var_dump($request->get_session());
        $response->json(["message" => "Login successful"]);
        // $response->redirect("calabash/user/info");
    }

    public static function dynamic_route($request, $response) {
        // var_dump($request->get_dynamic_uri_params()["id"]);
        $response->render('index.html', ['name' => "Dynamo because I am the dynamic route"]);
    }

}