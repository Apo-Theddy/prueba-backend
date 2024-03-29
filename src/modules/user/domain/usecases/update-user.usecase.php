<?php
require_once __DIR__ . "/../usecases/update-user.usecase.php";
require_once __DIR__ . "/../../../../../core/generics/usecase/usecase.generic.php";

use models\User;
use repositories\IUserRepository;
use usecase\IUsecase;

class UpdateUserUsecase implements IUsecase
{
 public function __construct(
  private readonly IUserRepository $userRepository
 ) {
 }

 /**
  * @param User $user
  * @return User
  */
 public function call($user): User
 {
  return $this->userRepository->updateUser($user);
 }
}
