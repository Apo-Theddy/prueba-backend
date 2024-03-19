<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Login</title>
 <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
 <div class="login-container">
  <h2>Login</h2>
  <?php if (isset($_GET['error'])) : ?>
   <div class="error-message"><?php echo $_GET['error']; ?></div>
  <?php endif; ?>
  <form action="user-form-login.php" method="POST">
   <div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
   </div>
   <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
   </div>
   <button type="submit">Login</button>
  </form>
 </div>
</body>

</html>