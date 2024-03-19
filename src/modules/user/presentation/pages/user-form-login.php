<?php

session_start();
$url = "http://192.168.18.85:8080/src/modules/user/infrastructure/routes/user.router.php/auth";

require_once __DIR__ . "/../../infrastructure/controllers/user.controller.php";
require_once __DIR__ . "/../../application/dtos/auth-user.dto.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
 $email = $_POST["email"] ?? '';
 $password = $_POST["password"] ?? '';

 if (!empty($email) && !empty($password)) {
  $userService = new UserController();

  $jsonBody = json_encode(array('email' => $email, 'password' => $password));
  $optinos = array(
   CURLOPT_URL => $url,
   CURLOPT_POST => true,
   CURLOPT_POSTFIELDS => $jsonBody,
   CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonBody)),
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_VERBOSE => true
  );
  $curl = curl_init();
  curl_setopt_array($curl, $optinos);

  $response = curl_exec($curl);

  if ($response === false) {
   echo "Error al obtener respuesta del servidor: " . curl_error($curl);
   return;
  }
  $responseStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);

  if ($responseStatusCode == 200) {
   $user = json_decode($response, true);
   setcookie("userId", $user['userId'], time() + (86400 * 30), "/");
   header("Location: profile-view.php");
  } else {
   header("Location: users-main-view.php?error=Credenciales invalidas");
  }
 }
}
