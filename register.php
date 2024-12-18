<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $courseandyear = mysqli_real_escape_string($conn, $_POST['courseandyear']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $role = mysqli_real_escape_string($conn, $_POST['role']); // Added line for role

    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'User already exists';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password not matched!';
        } elseif ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO `users` (name, courseandyear, email, password, image, role) VALUES ('$name', '$courseandyear', '$email', '$pass', '$image', '$role')") or die('query failed');

            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Registered successfully!';
                header('location:login.php');
            } else {
                $message[] = 'Registration failed!';
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <title>Home</title>


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


        .sidebar a:hover {
            font-size: 20px;
            color:#ffc000;
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

      .content {
   display: flex;
   flex-direction: column;
   align-items: center;
   justify-content: center;
   margin-left: auto; /* This will push the content to the center */
   padding: 20px;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: left;
    margin-top: 20px; /* Adjust margin as needed */
    margin-left: auto; /* Add this line to center the container */
}

      .profile-and-table {
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         margin-top: 20px; /* Adjust margin as needed */
      }

      .profile,
      .data-storage {
         background-color: rgba(255, 255, 255, 0.8);
         padding: 20px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         text-align: center;
         margin-top: 20px; /* Adjust margin as needed */
      }

      .profile {
        width: auto;
        margin: 0 auto;
        padding: 20px;

        border-radius: 10px;
        box-sizing: border-box;
    }

.profile h3 {
   margin-top: 10px; /* Add some space between the image and the text */
   font-size: 18px; /* Adjust font size as needed */
   color: #333; /* Set text color */
}

.profile img {
   width: 100px;
   height: 100px;
   border-radius: 50%;
   margin-bottom: 10px;
   border: 2px solid #fff; /* Add a white border around the image */
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.data-storage {
   background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
   padding: 20px;
   border-radius: 10px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle lift effect */
   overflow-x: auto; /* Add horizontal scroll if content overflows */
}

.data-storage table {
   width: 100%;
   border-collapse: collapse;
   margin-top: 15px; /* Add space between the table and other elements */
}

.data-storage th, .data-storage td {
   padding: 12px;
   text-align: left;
   border-bottom: 1px solid #ddd; /* Add a bottom border to separate rows */
}

.data-storage th {
   background-color: #f2f2f2; /* Light gray background for header */
}

.data-storage tbody tr:hover {
   background-color: #f5f5f5; /* Lighter background on hover */
}

/* Add specific styles for the hamburger icon */
#hamburgerIcon {
    padding: 15px;
    cursor: pointer;
}

/* Adjust the Home button styles */
.sidebar a:first-child {
    margin-top: 20px; /* Provide space between hamburger and Home button */
}

.container.active-sidebar {
    margin-left: 250px; /* Adjust the margin when sidebar is active */
}


/* Styles for sidebar icons */
.sidebar .btn {
    display: flex;
    align-items: center;
    padding: 15px;
    text-decoration: none;
    color: white;
}

/* Initially hide the names */
.sidebar .link-name {
    display: none;
    margin-left: 10px;
}

/* Show names on hover or in active state if needed */
.sidebar .btn:hover .link-name,
sidebar.active .link-name {
    display: inline;
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

.sidebar .link-name {
    display: none;
    margin-left: 10px;
}

.sidebar .btn:hover .link-name,
sidebar.active .link-name {
    display: inline;
}


</style>
   
<body>
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

<div class="wrapper">
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
      <input type="text" name="name" placeholder="Enter username" class="box" required>
      <input type="text" name="courseandyear" placeholder="Enter course and year" class="box">
      <input type="email" name="email" placeholder="Enter email" class="box" required>
      <input type="password" name="password" placeholder="Enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="Confirm password" class="box" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      
      <!-- Added input field for role -->
      <label for="role">Select User:</label>
      <select name="role" id="role" class="box" required>
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>

      <input type="submit" name="submit" value="Register Now" class="btn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</div>
<script>

document.getElementById("hamburgerIcon").addEventListener("click", function () {
    const sidebar = document.querySelector(".sidebar");
    const content = document.querySelector(".container");

    if (sidebar.style.width === "250px") {
        sidebar.style.width = "0";
        content.style.marginLeft = "0";
    } else {
        sidebar.style.width = "250px";
        content.style.marginLeft = "250px";
    }
});

const hamburgerIcon = document.getElementById("hamburgerIcon");
const sidebar = document.querySelector(".sidebar");
const content = document.querySelector(".container");

hamburgerIcon.addEventListener("click", function () {
    sidebar.classList.toggle("active");
    content.classList.toggle("active-sidebar");

    // Toggle the visibility of link names
    const areNamesVisible = sidebar.classList.contains('active');
    const linkNames = document.querySelectorAll('.link-name');
    linkNames.forEach(name => {
        name.style.display = areNamesVisible ? 'block' : 'none';
    });
});

// Hide sidebar when the user clicks outside the sidebar
document.addEventListener("click", function (e) {
    if (!sidebar.contains(e.target) && e.target !== hamburgerIcon) {
        sidebar.classList.remove("active");
        content.classList.remove("active-sidebar");

        // Hide link names when the sidebar is inactive
        const linkNames = document.querySelectorAll('.link-name');
        linkNames.forEach(name => {
            name.style.display = 'none';
        });
    }
});

</script>
</body>
</html>
