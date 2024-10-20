<?php

@include 'config.php';  // Include the database connection file

session_start();

if (isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);  // Same hashing as in registration

   // Query the database to check if the user exists
   $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass'";
   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);

      // Set session variable for user name
      $_SESSION['user_name'] = $row['name'];

      // Redirect to singleqr.php after successful login
      header('Location: index.html');
      exit();  // Ensure the script stops after redirection
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>Login Now</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
         }
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
   </form>
</div>

</body>
</html>
