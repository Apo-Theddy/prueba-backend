<?php
require_once __DIR__ . "/../../../../core/generics/usecase/usecase.generic.php";

use models\User;
use repository\IUserRepository;
use usecase\IUsecase;

class GetUserByIdUsecase implements IUsecase
{
 public function __construct(private readonly IUserRepository $userRepository)
 {
 }

 /**
  * @param int $userId
  * @return User
  */
 public function call($userId): User
 {
  return $this->userRepository->getUserById($userId);
 }
}
