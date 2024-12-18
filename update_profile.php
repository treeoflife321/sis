<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    $updateProfileStmt = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ? WHERE id = ?");
    mysqli_stmt_bind_param($updateProfileStmt, "ssi", $update_name, $update_email, $user_id);
    mysqli_stmt_execute($updateProfileStmt);
    mysqli_stmt_close($updateProfileStmt);
    $message[] = 'profile updated successfully!';

    $old_pass = md5(mysqli_real_escape_string($conn, $_POST['old_pass']));
$update_pass = md5(mysqli_real_escape_string($conn, $_POST['update_pass']));
$new_pass = md5(mysqli_real_escape_string($conn, $_POST['new_pass']));
$confirm_pass = md5(mysqli_real_escape_string($conn, $_POST['confirm_pass']));

// Check if the entered old password matches the user's current password
$select_pass_query = mysqli_query($conn, "SELECT password FROM users WHERE id = '$user_id'");
if ($select_pass_query) {
    $user_password = mysqli_fetch_assoc($select_pass_query)['password'];

    if ($update_pass != $user_password) {
        echo '<script>alert("Old password not matched! Profile update terminated.");</script>';
        echo '<script>window.location.href = "update_profile.php";</script>';
        exit();
    }
} else {
    echo '<script>alert("Error fetching user password. Profile update terminated.");</script>';
    echo '<script>window.location.href = "update_profile.php";</script>';
    exit();
}



    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image is too large';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE users SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'image updated successfully!';
        }
    }
}

$select = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Update Profile</title>
</head>

<style>

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

* {
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

.sidebar {
    height: none;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: none;
}

.sidebar a {
    padding: 15px;
    text-decoration: none;
    font-size: 15px;
    color: WHITE;
    display: block;
    transition: 0.3s;
}

.sidebar a i {
    margin-right: 10px;
}

.sidebar.active {
    width: 40px;
}

.sidebar a:hover {
    font-size: 20px;
    color: #ffc000;
}

.sidebar a.active {
    background-color: #ffc000;
    font-size: 20px;
    border-radius: 10px;
}

.sidebar a.active:hover {
    color: white;
}

.btn {
    display: inline-block;
    padding: 10px 15px;
    margin: 10px 0;
    text-decoration: none;
    color: #fff;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.delete-btn {
    display: inline-block;
    padding: 10px 15px;
    margin: 10px 0;
    text-decoration: none;
    background-color: #f44336;
    color: #fff;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.delete-btn:hover {
    background-color: #d32f2f;
}

.update-profile {
    width: 70%; /* Adjust width as needed */
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-sizing: border-box;
    max-width: 600px; /* Added max-width to limit the width of the profile update container */
}

.update-profile form input[type="text"],
.update-profile form input[type="email"],
.update-profile form input[type="password"],
.update-profile form textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

.update-profile .image-container {
    text-align: center;
}

.update-profile img {
    width: 150px; /* Adjust width as needed */
    height: 150px; /* Adjust height as needed */
    border-radius: 50%;
    margin-bottom: 10px;
    border: 2px solid #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.update-profile form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.flex {
    display: flex;
    justify-content: space-between;
    }

</style>

<body>
<div class="update-profile">
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if ($fetch['image'] == '') {
            echo '<img src="images/default-avatar.png">';
        } else {
            echo '<img src="uploaded_img/' . $fetch['image'] . '">';
        }
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message">' . $message . '</div>';
            }
        }
        ?>
<div class="container">
<div class="sidebar">
    <!-- Other sidebar links with icons and names -->
    <a href="home.php" class="btn">
        <i class="fas fa-home"></i>
        <span class="link-name">Home</span>
    </a>
    <a href="update_profile.php" class="btn">
        <i class="fas fa-user-edit"></i>
        <span class="link-name">Update Profile</span>
    </a>
    <a href="searchschedadmin.php" class="btn">
        <i class="fas fa-search"></i>
        <span class="link-name">Search Schedule</span>
    </a>
    <a href="index.php" class="btn">
        <i class="fas fa-calendar-alt"></i>
        <span class="link-name">Manage Schedule</span>
    </a>
    <a href="register.php" class="btn">
        <i class="fas fa-user-plus"></i>
        <span class="link-name">Create User Accounts</span>
    </a>
    <a href="archive.php" class="btn">
        <i class="fas fa-archive"></i>
        <span class="link-name">Archive</span>
    </a>
    <a href="adminwallthots.php" class="btn">
      <i class="fas fa-comment"></i>
      <span class="link-name">Freedom Wall</span>
   </a>
    <a href="managethots.php" class="btn">
        <i class="fas fa-comments"></i>
        <span class="link-name">Manage Thoughts</span>
    </a>
    <a href="thots.php?user_id=<?php echo $user_id; ?>" class="btn">
        <i class="fas fa-pen-square"></i>
        <span class="link-name">Write a Thought</span>
    </a>
    <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">
        <i class="fas fa-sign-out-alt"></i>
        <span class="link-name">Logout</span>
    </a>
   
    </div>
</div>

        <div class="flex">
            <div class="inputBox">
                <span>Username:</span>
                <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
                <span>Your Email:</span>
                <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                <span>Update Your Pic:</span>
                <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            </div>
            <div class="inputBox">
                <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                <span>Old Password:</span>
                <input type="password" name="update_pass" placeholder="Enter previous password" class="box" required>
                <span>New Password:</span>
                <input type="password" name="new_pass" placeholder="Enter new password" class="box" required>
                <span>Confirm Password:</span>
                <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box" required>
                <span>Confirm Password for Update:</span>
<input type="password" name="confirm_update_pass" placeholder="Confirm your password" class="box" required>
            </div>
        </div>
        <input type="submit" value="Update Profile" name="update_profile" class="btn">
        <a href="home.php" class="delete-btn">Go Back</a>
    </form>
</div>

</body>
</html>
