<?php

namespace services;

require_once __DIR__ . "/../../infrastructure/adapters/user.adapter.php";
require_once __DIR__ . "/../../domain/usecases/add-user.usecase.php";
require_once __DIR__ . "/../../domain/usecases/auth-user.usecase.php";
require_once __DIR__ . "/../../domain/usecases/get-user-by-id.usecase.php";
require_once __DIR__ . "/../../domain/usecases/get-users.usecase.php";
require_once __DIR__ . "/../../domain/usecases/remove-user.usecase.php";
require_once __DIR__ . "/../../domain/usecases/update-user.usecase.php";


use models\User;

use AddUserUsecase;
use AuthUserDto;
use AuthUserUsecase;
use GetUserByIdUsecase;
use GetUsersUsecase;
use RemoveUserUsecase;
use repositories\IUserRepository;
use UpdateUserUsecase;
use UserAdapter;

class UserService
{
 private readonly IUserRepository $userRepository;
 public function __construct()
 {
  $this->userRepository = new UserAdapter();
 }

 public function getUsers(): array
 {
  $getUsersUsecase = new GetUsersUsecase($this->userRepository);
  $users = $getUsersUsecase->call(null);
  return $users;
 }

 public function getUserById(int $userId): ?User
 {
  $getUserByIdUsecase = new GetUserByIdUsecase($this->userRepository);
  $user = $getUserByIdUsecase->call($userId);
  return $user;
 }

 public function authUser(AuthUserDto $authUserDto): ?User
 {
  $authUser = new AuthUserUsecase($this->userRepository);
  $user = $authUser->call($authUserDto);
  return $user;
 }

 public function addUser(User $user): ?User
 {
  $addUser = new AddUserUsecase($this->userRepository);
  $user = $addUser->call($user);
  return $user;
 }

 public function updateUser(User $user): ?User
 {
  $updateUser = new UpdateUserUsecase($this->userRepository);
  $user = $updateUser->call($user);
  return $user;
 }

 public function removeUser(int $userId): bool
 {
  $removeUser = new RemoveUserUsecase($this->userRepository);
  $userIsDeleted = $removeUser->call($userId);
  return $userIsDeleted;
 }
}
