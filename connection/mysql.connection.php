<?php

class MySqlConnection
{
 private static string $servername = "mariadb";
 private static string $username = "prueba_web";
 private static string $password = "123456";
 private static string $database = "prueba";
 public static function getConnection(): mysqli
 {
  return mysqli_connect(self::$servername, self::$username, self::$password, self::$database);
 }
}
