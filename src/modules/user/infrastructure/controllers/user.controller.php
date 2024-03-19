<?php

require_once __DIR__ . "/../../../../core/controller/base.controller.php";
require_once __DIR__ . "/../../application/services/user.service.php";
require_once __DIR__ . "/../../infrastructure/adapters/user.adapter.php";
require_once __DIR__ . "/../../domain/models/user.model.php";

use models\User;
use services\UserService;

class UserController extends BaseController
{
  private readonly UserService $userService;

  public function __construct()
  {
    $this->userService = new UserService();
  }

  public function getUsers()
  {
    $strErrorDesc = '';
    try {
      $users = $this->userService->getUsers();
      $usersArray = array_map(function ($user) {
        return $user->toArray();
      }, iterator_to_array($users));
      $responseData = json_encode($usersArray);
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage() . ' Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
      $this->sendOutput(json_encode(array("error" => $strErrorDesc)), array("Content-Type: application/json", $strErrorHeader));
      return;
    }
    $this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));
  }


  function getUserById(): ?User
  {
    $strErrorDesc = '';
    try {
      echo $_GET["userId"];
      // $urlComponents = $this->getQueryStringParams();
      // $user = $this->userService->getUserById();
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage() . " Something Wrong";
      $strHeader = "HTTP/1.1 500 Internal Server Error";
      $this->sendOutput(json_encode(array("error" => $strErrorDesc)), array("Content-Type: application/json", $strHeader));
    }
    return null;
  }

  public function addUser()
  {
    $strErrorDesc = '';
    try {
      $requiredAttributes = ["fullname", "email", "password", "openId"];
      $jsonBody = file_get_contents('php://input');
      $data = json_decode($jsonBody, true);
      if ($data != null) {
        foreach ($requiredAttributes as $attribute) {
          if (!isset($data[$attribute])) throw new Exception("The attribute '{$attribute}' is not defined");
        }
        $user =  User::Insert($data["fullname"], $data["email"], $data["password"], $data["openId"]);
        $newUser = $this->userService->addUser($user);
        $responseData = json_encode($newUser->toArray());
      }
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage() . ' Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
      $this->sendOutput(json_encode(array("error" => $strErrorDesc)), array("Content-Type: application/json", $strErrorHeader));
      return;
    }
    $this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));
  }
}

$userController = new UserController();
switch ($_SERVER["REQUEST_METHOD"]) {
  case "GET":
    if (!empty($_GET)) {
      $userController->getUserById();
    } else {
      $userController->getUsers();
    }
    break;
  case "POST":
    $userController->addUser();
    break;
}
