<?php
require_once __DIR__ . "/../usecases/auth-user.usecase.php";
require_once __DIR__ . "/../../../../../core/generics/usecase/usecase.generic.php";

use models\User;
use repositories\IUserRepository;
use usecase\IUsecase;

class AuthUserUsecase implements IUsecase
{
 public function __construct(
  private readonly IUserRepository $userRepository
 ) {
 }

 /**
  * @param AuthUserDto authUser  
  * @return ?User
  */
 public function call($authUser): ?User
 {
  return $this->userRepository->authUser($authUser);
 }
}
