<?php

@include 'config.php';  // Include the database connection file

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);  // Password encryption (consider using password_hash() for security)
   $cpass = md5($_POST['cpassword']);

   // Check if the user already exists
   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $error[] = 'User already exists!';
   } else {
      if ($pass != $cpass) {
         $error[] = 'Passwords do not match!';
      } else {
         // Insert new user into the database without user type
         $insert = "INSERT INTO user_form(name, email, password) VALUES('$name', '$email', '$pass')";
         if (mysqli_query($conn, $insert)) {
            // Redirect to singleqr.php after successful registration
            header('Location: singleqr.php');
            exit();  // Ensure the script stops after redirection
         } else {
            $error[] = 'Registration failed!';
         }
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="Enter your name">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <input type="submit" name="submit" value="Register Now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login Now</a></p>
   </form>
</div>

</body>
</html>
