<?php

require_once __DIR__ . "/../../../../../core/controller/base.controller.php";
require_once __DIR__ . "/../../application/services/user.service.php";
require_once __DIR__ . "/../../domain/models/user.model.php";
require_once __DIR__ . "/../../application/dtos/auth-user.dto.php";

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
      $userId = $_GET["userId"];
      $user = $this->userService->getUserById($userId);
      $responseData = json_encode($user->toArray());
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage();
      $strHeader = "HTTP/1.1 {$e->getCode()}";
      $this->sendOutput(json_encode(array("error" => $strErrorDesc)), array("Content-Type: application/json", $strHeader));
    }
    $this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));
  }

  public function authUser()
  {
    $responseData = "";
    try {
      $jsonBody = file_get_contents('php://input');
      $data = json_decode($jsonBody, true);
      if ($data != null) {
        $authUserDto = new AuthUserDto($data["email"], $data["password"]);
        $user = $this->userService->authUser($authUserDto);
        $responseData = json_encode($user->toArray());
      }
    } catch (Exception $e) {
      $strHeader = "HTTP/1.1 {$e->getCode()}";
      $strMessage = $e->getMessage();
      $this->sendOutput(json_encode(array("error" => $strMessage)), array("Content-Type: application/json", $strHeader));
    }
    $this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));
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
    $this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 201 Created"));
  }

  public function updateUser()
  {
    try {
      $jsonBody = file_get_contents("php://input");;
      $data = json_decode($jsonBody, true);
      if ($data != null) {
        if (!isset($data["userId"])) throw new Exception("No se ingreso el Id del usuario");
        $userId = $data["userId"];
        $user = $this->userService->getUserById($userId);

        $user->setFullname($data["fullname"]);
        $user->setPassword($data["password"]);
        $updatedUser = $this->userService->updateUser($user);
        $responseData = json_encode($updatedUser->toArray());
      }
    } catch (Exception $e) {
      $strErrDesc = $e->getMessage();
      $strHeader = "HTTP/1.1 500 {$e->getCode()}";
      $this->sendOutput(json_encode(array("error" => $strErrDesc)), array("Content-Type: application/json" => $strHeader),);
    }
    $this->sendOutput($responseData, array("Content-Type: application/json", "HTTP/1.1 200 OK"));
  }
}
