<?php
require_once __DIR__ . "/../controllers/user.controller.php";

class UserRouter
{
 public function __construct()
 {
  $userController = new UserController();
  switch ($_SERVER["REQUEST_METHOD"]) {
   case "GET":
    if (!empty($_GET["userId"])) {
     $userController->getUserById();
     break;
    }
    $userController->getUsers();
    break;
   case "POST":
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, '/auth') !== false) {
     $userController->authUser();
     break;
    }
    $userController->addUser();
    break;
   case "PUT":
    $userController->updateUser();
    break;
  }
 }
}
new UserRouter();
