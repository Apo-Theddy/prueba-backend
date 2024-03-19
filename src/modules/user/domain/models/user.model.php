<?php

namespace models;

class User
{
 private int $userId;
 private string $fullname;
 private string $email;
 private string $password;
 private string $openId;
 private ?string $creationDate;
 private ?string $updateDate;


 public function __construct(int $userId, string $fullname, string $email, string $password, string $openId, ?string $creationDate, ?string $updateDate)
 {
  $this->userId = $userId;
  $this->fullname = $fullname;
  $this->email = $email;
  $this->password = $password;
  $this->openId = $openId;
  $this->creationDate = $creationDate;
  $this->updateDate = $updateDate;
 }

 public static function Get(int $userId, string $fullname, string $email, string $password, string $openId, string $creationDate, string $updateDate): User
 {
  return new self($userId, $fullname, $email, $password, $openId, $creationDate, $updateDate);
 }

 public static function Insert(string $fullname, string $email, string $password, string $openId): User
 {
  return new self(-1, $fullname, $email, $password, $openId, null, null);
 }

 // Getters
 public function getUserId(): int
 {
  return $this->userId;
 }

 public function getFullname(): string
 {
  return $this->fullname;
 }

 public function getEmail(): string
 {
  return $this->email;
 }

 public function getPassword(): string
 {
  return $this->password;
 }

 public function getOpenId(): string
 {
  return $this->openId;
 }

 public function getCreationDate(): string
 {
  return $this->creationDate;
 }

 public function getUpdateDate(): string
 {
  return $this->updateDate;
 }

 // Setters
 public function setUserId(int $userId): void
 {
  $this->userId = $userId;
 }

 public function setFullname(string $fullname): void
 {
  $this->fullname = $fullname;
 }

 public function setEmail(string $email): void
 {
  $this->email = $email;
 }

 public function setPassword(string $password): void
 {
  $this->password = $password;
 }

 public function setOpenId(string $openId): void
 {
  $this->openId = $openId;
 }

 public function setCreationDate(string $creationDate): void
 {
  $this->creationDate = $creationDate;
 }

 public function setUpdateDate(string $updateDate): void
 {
  $this->updateDate = $updateDate;
 }

 public function toArray(): array
 {
  return [
   "userId" => $this->userId,
   "fullname" => $this->fullname,
   "email" => $this->email,
   "password" => $this->password,
   "openId" => $this->openId,
   "creationDate" => $this->creationDate,
   "updateDate" => $this->updateDate
  ];
 }
}
