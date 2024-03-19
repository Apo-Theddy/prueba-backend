<?php

class AuthUserDto
{
 public string $email;
 public string $password;

 public function _construct(string $email, string $password)
 {
  $this->email = $email;
  $this->password = $password;
 }

 // GETTERS
 public function getEmail(): string
 {
  return $this->email;
 }

 public function getPassword(): string
 {
  return $this->password;
 }

 // SETTERS
 public function setEmail(string $email): void
 {
  $this->email = $email;
 }

 public function setPassword(string $password): void
 {
  $this->password = $password;
 }
}
