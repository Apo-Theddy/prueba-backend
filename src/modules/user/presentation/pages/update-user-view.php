<?php

$fullname = $_POST["fullname"];
$password = $_POST["password"];

$userId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
$user = array(
 "userId" => $userId,
 "fullname" => $fullname,
 "password" => $password
);

$url = "http://192.168.18.85:8080/src/modules/user/infrastructure/routes/user.router.php/";

$jsonBody = json_encode($user);

$curlOptions = array(
 CURLOPT_URL => $url,
 CURLOPT_CUSTOMREQUEST => "PUT",
 CURLOPT_POSTFIELDS => $jsonBody,
 CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonBody)),
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_VERBOSE => true
);

$curl = curl_init();
curl_setopt_array($curl, $curlOptions);

$response = curl_exec($curl);
curl_close($curl);

if ($response == false) {
 echo "No se pudo actualizar el usuario: " . curl_error($curl);
} else {
 header("Location: profile-view.php");
}
