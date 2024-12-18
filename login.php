<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'") or die('Query failed');

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on user role
        if ($_SESSION['role'] == 'admin') {
            header('location: home.php');
            exit();
        } elseif ($_SESSION['role'] == 'user') {
            header('location: userhome.php');
            exit();
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>


</head>

<style>
   @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url(pics/ustp.png) no-repeat;
    background-size: cover;
    background-position: center;
}

.wrapper {
    text-align: center;
    width: 500px;
    background: #FFBF00;
    border: 2px solid rgba(255, 191, 0, 1);
    backdrop-filter: blur(20px);
    box-shadow: 0 0 5px rgba(255, 191, 0, 1);
    color: #191970;
    border-radius: 10px;
    padding: 30px 40px;
}

.wrapper h1 {
    font-size: 28px;
    text-align: center;
}

.wrapper .form-group {
    position: relative;
    width: 100%;
    height: 50px;
    margin: 40px 0;
}

.form-group i {
    position: absolute;
    right:20px;
    top: 50%;
    transform: translateY(-50%);
    color: #191970;
    font-size: 18px;
}

.form-group input {
    width: 400px;
    height: 50px;
    border: none;
    outline: none;
    border: #191970;
    border-radius: 40px;
    font-size: 16px;
    color: #191970;
    padding: 20px 45px 20px 20px;
}

.form-group input::placeholder {
    color: #191970;
}

.wrapper .remember-forgot {
    display: flex;
    justify-content: space-between;
    font-size: 14.5px;
    margin: -15px 0 15px;
}

.remember-forgot label input {
    accent-color: white;
    margin-right: 3px;
}

.remember-forgot a {
    color: #191970;
    text-decoration: none;
}

.remember-forgot a:hover {
    text-decoration: underline;
}

.wrapper .btn {
    width: 100%;
    height: 45px;
    background: #191970;
    border: none;
    outline: none;
    border-radius: 40px;
    color: white;
    box-shadow: 0 0 10px rgba(255, 255, 255, .1);
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
}


.toggle-password {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

</style>

<body>
   
<div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <?php
      if (isset($message)) {
         foreach ($message as $message) {
            echo '<div class="message">' . $message . '</div>';
         }
      }
      ?>

      <div class="wrapper">
                <h1>USTP SCHEDULE INFORMATION</h1>
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" name="password" class="form-control" id="password">
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <div class="remember-forgot">
                   <label><input type="checkbox" name="remember">Remember me</label>
                   <a href="#">Forgot password</a>
               </div>
                <div class="form-btn">
                    <input type="submit" value="Login" name="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>


</body>
</html>
