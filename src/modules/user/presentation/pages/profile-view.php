<!DOCTYPE html>
<html lang="es">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Perfil de Usuario</title>
 <style>
  body {
   font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
   background-color: #e8eff1;
   margin: 0;
   padding: 0;
   display: flex;
   justify-content: center;
   align-items: center;
   height: 100vh;
   color: #505050;
  }

  .container {
   background-color: #ffffff;
   border-radius: 5px;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
   padding: 25px;
   max-width: 350px;
   width: 100%;
   box-sizing: border-box;
  }

  h1 {
   text-align: center;
   color: #27ae60;
   margin-bottom: 30px;
  }

  .user-info {
   background-color: #f9f9f9;
   padding: 15px;
   border-radius: 5px;
  }

  .user-info p {
   margin: 10px 0;
   line-height: 1.6;
  }

  .user-info label {
   display: block;
   margin-bottom: 5px;
   font-weight: 600;
  }

  .edit-form {
   display: none;
  }

  .edit-form input[type="text"],
  .edit-form input[type="email"],
  .edit-form input[type="password"] {
   width: calc(100% - 20px);
   padding: 10px;
   margin-bottom: 15px;
   border: 1px solid #ccc;
   border-radius: 5px;
   box-sizing: border-box;
   font-size: 16px;
  }

  .edit-form input[type="submit"] {
   background-color: #27ae60;
   color: #fff;
   border: none;
   border-radius: 5px;
   padding: 10px 20px;
   cursor: pointer;
   font-size: 16px;
   width: 100%;
  }

  .edit-form input[type="submit"]:hover {
   background-color: #218c54;
  }

  .edit-button {
   background-color: #2980b9;
   color: #fff;
   border: none;
   border-radius: 5px;
   padding: 10px 20px;
   cursor: pointer;
   font-size: 16px;
   width: 100%;
   margin-bottom: 15px;
  }

  .edit-button:hover {
   background-color: #1c638e;
  }

  .comments-section {
   margin-top: 30px;
  }

  .comments-section textarea {
   width: 100%;
   padding: 10px;
   margin-bottom: 15px;
   border: 1px solid #ccc;
   border-radius: 5px;
   box-sizing: border-box;
   font-size: 16px;
  }

  .comments-section input[type="submit"] {
   background-color: #27ae60;
   color: #fff;
   border: none;
   border-radius: 5px;
   padding: 10px 20px;
   cursor: pointer;
   font-size: 16px;
  }

  .comments-section {
   background-color: #f9f9f9;
   padding: 15px;
   border-radius: 5px;
   margin-bottom: 20px;
   margin-right: 30px;
   height: 50%;
  }

  .comment {
   margin-bottom: 10px;
   padding: 10px;
   border: 1px solid #ccc;
   border-radius: 5px;
   background-color: #fff;
  }

  .comment p {
   margin: 5px;
  }

  .comments-section input[type="submit"]:hover {
   background-color: #218c54;
  }
 </style>
</head>

<body>
 <?php

 $comments = [
  ['user_id' => 1, 'username' => 'Usuario1', 'comment' => 'Este es un comentario de ejemplo.', 'likes' => 5],
  ['user_id' => 2, 'username' => 'Usuario2', 'comment' => 'Otro comentario de ejemplo.', 'likes' => 10]
 ];

 $userId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
 $url = "http://192.168.18.85:8080/src/modules/user/infrastructure/routes/user.router.php/?userId={$userId}";

 $curl = curl_init();

 curl_setopt($curl, CURLOPT_URL, $url);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

 $response = curl_exec($curl);

 curl_close($curl);

 $user = json_decode($response, true);
 ?>
 <div class="comments-section">
  <h2>Comentarios</h2>
  <?php foreach ($comments as $comment) : ?>
   <div class="comment">
    <p><strong><?php echo $comment['username']; ?>:</strong> <?php echo $comment['comment']; ?></p>
    <p><strong>Likes:</strong> <?php echo $comment['likes']; ?></p>
   </div>
  <?php endforeach; ?>
 </div>
 <div class="container">
  <h1>Perfil de Usuario</h1>
  <div class="user-info">
   <p><label>User ID:</label> <?php echo $user["userId"]; ?></p>
   <p><label>Fullname:</label> <?php echo $user["fullname"]; ?></p>
   <p><label>Email:</label> <?php echo $user["email"]; ?></p>
   <p><label>Password:</label> <?php echo $user["password"]; ?></p>
   <p><label>Open ID:</label> <?php echo $user["openId"]; ?></p>
   <p><label>Creation Date:</label> <?php echo $user["creationDate"]; ?></p>
   <p><label>Update Date:</label> <?php echo $user["updateDate"]; ?></p>
  </div>
  <button class="edit-button" onclick="showEditForm()">Editar Perfil</button>
  <form class="edit-form" id="editForm" method="post" action="update-user-view.php">
   <label for="fullname">Nombre Completo:</label>
   <input type="text" id="fullname" name="fullname" placeholder="Nombre Completo" value="<?php echo $user['fullname']; ?>">
   <label for="password">Contraseña:</label>
   <input type="password" id="password" name="password" placeholder="Contraseña" value="<?php echo $user['password']; ?>">
   <input type="submit" value="Guardar Cambios">
  </form>

  <div class="comments-section">
   <h2>Comentarios</h2>
   <textarea name="comment" id="comment" placeholder="Escribe tu comentario aquí"></textarea>
   <input type="submit" value="Publicar comentario">
  </div>

  <script>
   function showEditForm() {
    var form = document.getElementById('editForm');
    var userInfo = document.querySelector('.user-info');
    var editButton = document.querySelector('.edit-button');

    if (form.style.display === 'none') {
     form.style.display = 'block';
     userInfo.style.display = 'none';
     editButton.style.display = 'none';
    } else {
     form.style.display = 'none';
     userInfo.style.display = 'block';
     userInfo.style.display = 'block';
     editButton.style.display = 'block';
    }
   }
  </script>
</body>

</html>