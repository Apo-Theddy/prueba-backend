<?php

class MySqlConnection
{
 private static string $servername = "localhost";
 private static string $username = "root";
 private static string $password = "";
 private static string $database = "prueba";
 public static function getConnection(): mysqli
 {
  return mysqli_connect(self::$servername, self::$username, self::$password, self::$database);
 }
}
