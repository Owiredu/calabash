<?php
// declare namespace
namespace Controllers;

// require models
require(__DIR__ . '/../models/UserModel.php');
// require response
require(__DIR__ . '/../lib/classes/ResponseClass.php');

// User controller
class UserController {

    public static function hello() {
        // send response
        $response = new \Response\Response();
        $response->render('index.html.twig', ['name' => "Nana Kofi"]);
    }

}