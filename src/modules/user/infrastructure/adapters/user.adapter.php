<?php

require_once  __DIR__ . "/../../domain/repositories/user.repository.php";
require_once __DIR__ . "../../../../../../connection/mysql.connection.php";
require_once __DIR__ . "../../../application/exceptions/user-not-found.exception.php";
require_once __DIR__ . "../../../application/exceptions/auth-invalid-credentials.exception.php";
require_once __DIR__ . "../../../application/exceptions/user-update-failed.exception.php";

use models\User;
use repositories\IUserRepository;

class UserAdapter implements IUserRepository
{
  private string $tableName = "user";

  private mysqli $connection;

  public function __construct()
  {
    $this->connection = MysqlConnection::getConnection();
  }

  public function getUsers(): array
  {
    $query = "SELECT * FROM {$this->tableName}";
    $results = $this->connection->query($query);
    $users = [];
    if ($results->num_rows > 0) {
      while ($row = $results->fetch_assoc()) {
        $user = User::Get($row["id"], $row["fullname"], $row["email"], $row["pass"], $row["openid"], $row["creation_date"], $row["update_date"]);
        $users[] = $user;
      }
      $results->close();
    }
    return $users;
  }

  public function getUserById(int $userId): ?User
  {
    $query = "SELECT fullname, email, pass, openid, creation_date, update_date FROM {$this->tableName} WHERE id = ? LIMIT 1";
    $statement = $this->connection->prepare($query);
    $statement->bind_param('i', $userId);
    $user = null;
    if ($statement->execute()) {
      $result = $statement->get_result();
      if ($result->num_rows <= 0) {
        throw new UserNotFoundException("No se pudo obtener el usuario con ID: {$userId}", 404);
      }

      if ($row = $result->fetch_assoc()) {
        $user = new User($userId, $row["fullname"], $row["email"], $row["pass"], $row["openid"], $row["creation_date"], $row["update_date"]);
      }
      $result->close();
    } else {
      throw new Exception("Ocurrio un problema interno al obtener el usuario");
    }
    $statement->close();
    return $user;
  }

  public function authUser(AuthUserDto $authUserDto): ?User
  {
    $query = "SELECT id, fullname, email, pass, openid, creation_date, update_date FROM {$this->tableName} WHERE email = ? AND pass = ? LIMIT 1";
    $statement = $this->connection->prepare($query);
    $email = $authUserDto->getEmail();
    $pass = $authUserDto->getPassword();

    $user = null;
    $statement->bind_param('ss', $email, $pass);

    if ($statement->execute()) {
      $result = $statement->get_result();
      if ($result->num_rows <= 0) {
        throw new InvalidCredentialsException("Email o Contrasenia Erroneas, Verifique las credenciales");
      }

      if ($row = $result->fetch_assoc()) {
        $user =  User::Get($row["id"], $row["fullname"], $row["email"], $pass, $row["openid"], $row["creation_date"], $row["update_date"]);
      }
      $result->close();
    } else {
      throw new Exception("Ocurrio un error al validar las credenciales");
    }
    $statement->close();
    return $user;
  }

  public function addUser(User $user): ?User
  {
    $query = "INSERT INTO {$this->tableName} (fullname, email, pass, openid) VALUES (?, ?, ?, ?)";
    $statement = $this->connection->prepare($query);

    $fullname = $user->getFullname();
    $email = $user->getEmail();
    $pass = $user->getPassword();
    $openId = $user->getOpenId();

    $statement->bind_param("ssss", $fullname, $email, $pass, $openId);
    if (!$statement->execute()) {
      throw new UserCreationFailedException("No se pudo completar el registro de usuario");
    }
    $userId = $statement->insert_id;
    $user->setUserId($userId);
    $statement->close();
    return $user;
  }

  public function updateUser(User $user): ?User
  {
    $query = "UPDATE {$this->tableName} SET fullname = ?, pass = ?, update_date = ? WHERE id = ?";
    $statement = $this->connection->prepare($query);

    $this->getUserById($user->getUserId());

    $userId = $user->getUserId();
    $fullname = $user->getFullname();
    $pass = $user->getPassword();
    date_default_timezone_set('America/Lima');

    $updateDate = date("Y-m-d H:i:s");
    $statement->bind_param("sssi", $fullname, $pass, $updateDate, $userId);
    if (!$statement->execute()) {
      throw new UserUpdateFailedException("No se pudo actualizar el usuario: " . $statement->error);
    }
    $statement->close();
    return $user;
  }

  public function removeUser(int $userId): bool
  {
    $userIsDeleted = false;
    $query = "DELETE FROM {$this->tableName} WHERE id = ?";
    $statement = $this->connection->prepare($query);
    $statement->bind_param("i", $userId);
    if (!$statement->execute()) throw new UserDeletionFailedException("No se pudo eliminar el usuario con el ID: " . $userId);
    $userIsDeleted = true;
    return $userIsDeleted;
  }
}
