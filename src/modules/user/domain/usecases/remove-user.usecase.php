<?php
require_once __DIR__ . "/../usecases/remove-user.usecase.php";
require_once __DIR__ . "/../../../../../core/generics/usecase/usecase.generic.php";

use repositories\IUserRepository;
use usecase\IUsecase;

class RemoveUserUsecase implements IUsecase
{
 public function __construct(
  private readonly IUserRepository $userRepository
 ) {
 }

 /**
  * @param int $userId
  * @return bool
  */
 public function call($userId): bool
 {
  return $this->userRepository->removeUser($userId);
 }
}
