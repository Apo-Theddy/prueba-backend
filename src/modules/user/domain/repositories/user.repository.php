<?php

namespace repositories;

use ArrayObject;
use AuthUserDto;
use models\User;

interface IUserRepository
{
 /**
  * @return array
  */
 public function getUsers(): array;

 /**
  * @param int $userId
  * @return User
  */
 public function getUserById(int $userId): ?User;

 /**
  * @param AuthUserDto $authUserDto
  * @return User
  */
 public function authUser(AuthUserDto $authUserDto): ?User;

 /**
  * @param User $user 
  * @return User
  */
 public function addUser(User $user): ?User;

 /**
  * @param User $user 
  * @return User
  */
 public function updateUser(User $user): ?User;

 /**
  * @param int $userId 
  * @return bool
  */
 public function removeUser(int $userId): bool;
}
