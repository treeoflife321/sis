<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    
    // Additional field for admin registration
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $insert = mysqli_query($conn, "INSERT INTO `users` (name,email, password, image, role) VALUES ('$name', '$email', '$password', '$image', '$role')") or die('Query failed');

    if ($insert) {
        move_uploaded_file($temp_image, "uploaded_img/$image");
        $message[] = 'Registration successful!';

        // Redirect based on user role
        if ($role == 'admin') {
            header('location: home.php');
            exit();
        } else {
            header('location: userhome.php');
            exit();
        }
    } else {
        $message[] = 'Registration failed!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Register Now</h3>
      <?php
      if (isset($message)) {
         foreach ($message as $message) {
            echo '<div class="message">' . $message . '</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="Enter name" class="box" required>
      <input type="email" name="email" placeholder="Enter email" class="box" required>
      <input type="password" name="password" placeholder="Enter password" class="box" required>
      <input type="file" name="image" accept="image/*" class="box">

      <!-- Additional field for admin registration -->
      <input type="hidden" name="role" value="admin">

      <input type="submit" name="submit" value="Register" class="btn">
   </form>
</div>

</body>
</html>
