<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
   exit();
}

if (isset($_GET['logout'])) {
   unset($user_id);
   session_destroy();
   header('location:login.php');
   exit();
}

// Get the user ID from the URL
$user_id = $_GET['user_id'];

// Fetch user details only if the user is logged in
$fetch = []; // Initialize $fetch as an empty array

if (isset($_SESSION['user_id'])) {
    // Fetch user details
    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
        $fetch = mysqli_fetch_assoc($select);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted

    // Get values from the HTML form
    $stud_name = $fetch['name']; // Use the student name from the fetched details
    $thot = $_POST['thot'];
    $anonymous = isset($_POST['anonymous']) ? "Yes" : "No"; // Use "Yes" or "No" based on checkbox state

    // Insert data into the 'thot' table
    $sql = "INSERT INTO thots (stud_name, thot, anony) VALUES ('$stud_name', '$thot', '$anonymous')";

    if (mysqli_query($conn, $sql)) {
        echo "Thought posted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch thoughts from the database
$sql = "SELECT stud_name, thot FROM thots";
$result = mysqli_query($conn, $sql);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    $thoughts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $thoughts = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Freedom wall</title>
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

        .sidebar.active {
            width: 40px;
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
            margin-left: 270px;
            padding: 20px;
        }

        .navbar {
            background-color: #007bff;
            color: white;
            padding: 15px;
        }


        .recent-texts-box {
  padding: 150px;
  border-radius: 5px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
  margin-top: 10px;
  background-color: rgba(255, 255, 255, 0.2);
            border-style: ridge;
  color: white;
  border-color: #ffc000;
}
.message-box h2 {
        padding: 10px;
        color: white;
        width: 16%;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.2);
            border-style: ridge;
        border-color: #ffc000;
    }
    #message-input {
        background-color: rgba(255, 255, 255, 0.2);
            border-style: ridge;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px;
    }
    ::placeholder {
        color: #999;
        font-size: 16px;
    }

label[for="anonymous-checkbox"] {
    color: white;
    font-weight: bold;
    font-size: 16px;
}

.recent-texts-container {
    background-color: rgba(255, 255, 255, 0.2);
    border-style: ridge;
    border-color: #ffc000;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
        #recent-text-list {
            list-style-type: none;
            padding: 0;
            
        }

        #recent-text-list li {
            margin-bottom: 10px;
        }
        .content {
    flex: 1;
    padding: 20px;
}

textarea {
    width: 100%;
    height: 100px;
    margin-bottom: 10px;
}
.content h1 {
        color: white;
        font-size: 50px;
}

    </style>
</head>
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

    <div class="content">
        <div class="search-box">
            <!-- Add your search input here if needed -->
        </div>
        <h1>FREEDOM WALL</h1>
        <div class="message-box">
            <h2> <?php echo $fetch['name']; ?></h2>
        <form action="" method="post">
        <textarea name="thot" placeholder="Type your message..."></textarea>
        <label for="anonymous-checkbox">Make me anonymous:</label>
        <input type="checkbox" name="anonymous" id="anonymous-checkbox">
        <button type="submit" id="post-button">Post</button>
        </form>
    </div>
    <div class="recent-texts-container">
    <ul id="recent-text-list">
    <?php foreach ($thoughts as $thought): ?>
        <?php if ($thought['stud_name'] === $fetch['name']): ?>
            <li><?php echo $thought['stud_name'] . ': ' . $thought['thot']; ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
    </ul>
    </div>
</body>
</html>
