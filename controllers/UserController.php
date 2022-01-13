<?php
// declare namespace
namespace Controllers;

// require modules
include_once(__DIR__ . '/../models/UserModel.php');
include_once(__DIR__ . '/../lib/classes/ResponseClass.php');

// use namespaces
use Lib\Class\Response as HTTPResponse;

// User controller
class UserController {

    public static function hello(): string {
        // send response
        $response = new HTTPResponse();
        return $response->render('index.html.twig', ['name' => "Nana Kofi"]);
    }

}