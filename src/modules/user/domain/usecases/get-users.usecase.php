<?php
require_once __DIR__ . "/../usecases/get-users.usecase.php";
require_once __DIR__ . "/../../../../../core/generics/usecase/usecase.generic.php";

use repositories\IUserRepository;
use usecase\IUsecase;


class GetUsersUsecase implements IUsecase
{
 public function __construct(private readonly IUserRepository $userRepository)
 {
 }

 /**
  * @return array
  */
 public function call($param): array
 {
  return $this->userRepository->getUsers();
 }
}
