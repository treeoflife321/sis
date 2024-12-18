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

// Fetch all thoughts from the database
$sql = "SELECT * FROM thots";
$result = mysqli_query($conn, $sql);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    $thoughts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $thoughts = [];
}

// Handle approval or disapproval logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $thoughtId = $_POST['approve'];
        updateThoughtStatus($conn, $thoughtId, 'Yes');
    } elseif (isset($_POST['disapprove'])) {
        $thoughtId = $_POST['disapprove'];
        deleteThought($conn, $thoughtId);
    }
}

// Function to update thought status
function updateThoughtStatus($conn, $thoughtId, $status) {
    $sql = "UPDATE thots SET approved = '$status' WHERE id = $thoughtId";
    mysqli_query($conn, $sql);
}

// Function to delete thought
function deleteThought($conn, $thoughtId) {
    $sql = "DELETE FROM thots WHERE id = $thoughtId";
    mysqli_query($conn, $sql);
}

// Separate thoughts into approved and unapproved
$approvedThoughts = [];
$unapprovedThoughts = [];

foreach ($thoughts as $thought) {
    if ($thought['approved'] === 'Yes') {
        $approvedThoughts[] = $thought;
    } else {
        $unapprovedThoughts[] = $thought;
    }
}

// Combine the arrays, placing approved thoughts at the bottom
$combinedThoughts = array_merge($unapprovedThoughts, $approvedThoughts);
?>


<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <title>Manage Thoughts</title>
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
   transition: 0.3s;
   z-index: 1;
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
   display: flex;
   flex-direction: column;
   align-items: center;
   justify-content: center;
   margin-left: auto; /* This will push the content to the center */
   padding: 20px;
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

        .footer {
            background-color: #007bff;
            color: white;
            padding: 15px;
            position: fixed;
            bottom: 0;
            right: 0;
            width: 79.5%;
            text-align: right;
        }

        .recent-texts-box {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        #recent-text-list {
            list-style-type: none;
            padding: 0;
        }


        .thought {
            display: flex;
            align-items: center;
            padding: 10px; /* Increased padding for wider area */
            background-color: #ffc000;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
            margin-top: 15px;
        }

        .thought .profile-pic img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }


        .approval-button .disapproval-button{
            background-color: white;
            color: white;
            border: none;
            padding: 1px 5px;
            cursor: pointer;
            margin-left: 500px;
            border-radius: 5px;
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
<div class="thoughts-section">
    
    <?php foreach ($combinedThoughts as $thought): ?>
        <div class="thought">
            <?php
            // Fetch user image based on the name
            $profilePicSql = "SELECT image FROM users WHERE name = '{$thought['stud_name']}'";
            $profilePicResult = mysqli_query($conn, $profilePicSql);

            if (mysqli_num_rows($profilePicResult) > 0) {
                $profilePicData = mysqli_fetch_assoc($profilePicResult);
                echo '<div class="profile-pic"><img src="uploaded_img/' . $profilePicData['image'] . '" alt="Profile Pic"></div>';
            } else {
                echo '<div class="profile-pic">No Image</div>';
            }
            ?>

            <p>
                <?php echo $thought['stud_name']; ?>'s thought:
                <?php echo $thought['thot']; ?>
                <?php if ($thought['approved'] === 'Yes'): ?>
                    <span class="approved">(Approved)</span>
                    <div class="approval-disapproval">
                        <form method="post" action="">
                            <!-- Hidden input field to send the thought ID -->
                            <input type="hidden" name="thought_id" value="<?php echo $thought['id']; ?>">
                            <button class="disapproval-button" type="submit" name="disapprove" value="<?php echo $thought['id']; ?>">❌</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="approval-disapproval">
                        <form method="post" action="">
                            <button class="disapproval-button" type="submit" name="disapprove" value="<?php echo $thought['id']; ?>">❌</button>
                            <button class="approval-button" type="submit" name="approve" value="<?php echo $thought['id']; ?>">✔️</button>
                        </form>
                    </div>
                <?php endif; ?>
            </p>
        </div>
    <?php endforeach; ?>
</div>

    <script>
        // Add JavaScript for approval and disapproval buttons
        function approveThought(thoughtId) {
            // Handle approval logic here (e.g., update thought status in the database)
            console.log('Approved thought with ID ' + thoughtId);
        }

        function disapproveThought(thoughtId) {
            // Handle disapproval logic here (e.g., update thought status in the database)
            console.log('Disapproved thought with ID ' + thoughtId);
        }

        function showApprovedThoughts() {
        // Hide all thoughts
        document.querySelectorAll('.thought').forEach(function(thought) {
            thought.style.display = 'none';
        });

        // Show approved thoughts
        document.querySelectorAll('.thought .approved').forEach(function(approved) {
            approved.closest('.thought').style.display = 'flex';
        });
    }

    function showUnapprovedThoughts() {
        // Hide all thoughts
        document.querySelectorAll('.thought').forEach(function(thought) {
            thought.style.display = 'none';
        });

        // Show unapproved thoughts
        document.querySelectorAll('.thought:not(.approved)').forEach(function(unapproved) {
            unapproved.style.display = 'flex';
        });
    }

    </script>
</body>
</html>