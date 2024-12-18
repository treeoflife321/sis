<?php
include 'config.php';

// Start or resume the session
session_start();

// Fetch thoughts with "Yes" in the approved attribute from the database
$sql = "SELECT stud_name, thot, anony FROM thots WHERE approved = 'Yes'";
$result = mysqli_query($conn, $sql);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    $thoughts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $thoughts = [];
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Fetch user details
    $fetch = []; // Initialize $fetch as an empty array
    $select = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
        $fetch = mysqli_fetch_assoc($select);
    }
} else {
    // Redirect to login page if not logged in
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <title>Wall of Thoughts</title>
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

.success-message {
            color: green;
            margin-bottom: 10px;
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
    color: white; /* Adjust the text color */
    font-size: 16px; /* Adjust the font size */
}
.delete-icon {
    cursor: pointer;
    color: #f44336; /* Adjust the color of the delete icon */
    margin-left: 10px;
}

.centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .recent-texts-container {
            /* ... (your existing styles for .recent-texts-container) */
            /* Additional styles for centering */
            margin: auto;
        }

        .profile-pic img {
    width: auto; /* Allow the width to adjust automatically */
    height: auto; /* Allow the height to adjust automatically */
    max-width: 25px; /* Set a maximum width if needed */
    max-height: 25px; /* Set a maximum height if needed */
    border-radius: 50%; /* To make the image circular (if desired) */
}
.thought {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-pic {
            margin-right: 10px;
        }

        .profile-pic img {
            width: 50px; /* Adjust the width of the profile picture */
            height: 50px; /* Adjust the height of the profile picture */
            border-radius: 50%;
        }

        #recent-text-list {
            list-style-type: none;
            padding: 0;
            color: white;
            font-size: 16px;
        }

        #recent-text-list li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <a href="userhome.php" class="btn"><i class="fas fa-home"></i>Home</a>
    <a href="user_updp.php" class="btn"><i class="fas fa-user-edit"></i>Update Profile</a>
    <a href="searchsched.php" class="btn"><i class="fas fa-search"></i>Search Schedule</a>
    <a href="userthots.php?user_id=<?php echo $user_id; ?>" class="btn"><i class="fas fa-pen-square"></i>Post on Wall</a>
    <a href="wallthots.php" class="btn"><i class="fas fa-comment"></i>Freedom Wall</a>
    <a href="userhome.php?logout=<?php echo $user_id; ?>" class="delete-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>
<div class="content">
    <h1>STUDENT'S WALL OF THOUGHTS</h1>

    <div class="recent-texts-container">
        <div class="thoughts-section">
            <?php foreach ($thoughts as $thought): ?>
                <?php if ($thought['anony'] === 'No'): ?>
                    <div class="thought">
                        <div class="profile-pic">
                            <?php
                            // Fetch user image based on the name
                            $profilePicSql = "SELECT image FROM users WHERE name = '{$thought['stud_name']}'";
                            $profilePicResult = mysqli_query($conn, $profilePicSql);

                            if (mysqli_num_rows($profilePicResult) > 0) {
                                $profilePicData = mysqli_fetch_assoc($profilePicResult);
                                echo '<img src="uploaded_img/' . $profilePicData['image'] . '" alt="Profile Pic">';
                            } else {
                                echo 'No Image';
                            }
                            ?>
                        </div>
                        <ul id="recent-text-list">
                            <li>
                                <?php echo $thought['stud_name'] . ': ' . $thought['thot']; ?>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>


</html>