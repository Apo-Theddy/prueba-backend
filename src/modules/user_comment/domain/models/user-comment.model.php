<?php

class UserComment
{
 private int $id;
 private int $userId;
 private string $commentText;
 private int $likes;
 private string $creationDate;
 private string $updateDate;

 public function __construct(int $id, int $userId, string $commentText, int $likes, string $creationDate, string $updateDate)
 {
  $this->id = $id;
  $this->userId = $userId;
  $this->commentText = $commentText;
  $this->likes = $likes;
  $this->creationDate = $creationDate;
  $this->updateDate = $updateDate;
 }

 public static function Insert(int $userID, string $commentText, int $likes, string $creationDate, string $updateDate)
 {
  return new self(-1, $userID, $commentText, $likes, $creationDate, $updateDate);
 }

 public function getId()
 {
  return $this->id;
 }

 public function setId($id)
 {
  $this->id = $id;
 }

 public function getUserId()
 {
  return $this->userId;
 }

 public function setUserId($userId)
 {
  $this->userId = $userId;
 }

 public function getCommentText()
 {
  return $this->commentText;
 }

 public function setCommentText($commentText)
 {
  $this->commentText = $commentText;
 }

 public function getLikes()
 {
  return $this->likes;
 }

 public function setLikes($likes)
 {
  $this->likes = $likes;
 }

 public function getCreationDate()
 {
  return $this->creationDate;
 }

 public function setCreationDate($creationDate)
 {
  $this->creationDate = $creationDate;
 }

 public function getUpdateDate()
 {
  return $this->updateDate;
 }

 public function setUpdateDate($updateDate)
 {
  $this->updateDate = $updateDate;
 }
}
