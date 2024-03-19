<?php

require_once __DIR__ . "/../../../../core/generics/usecase/usecase.generic.php";

use models\User;
use repository\IUserRepository;
use usecase\IUsecase;

class AddUserUsecase implements IUsecase
{

 public function __construct(
  private readonly IUserRepository $userRepository
 ) {
 }

 /**
  * @param User $user
  * @return 
  */
 public function call($user): User
 {
  return $this->userRepository->addUser($user);
 }
}
