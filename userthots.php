<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['logout'])) {
    unset($_SESSION['user_id']);
    session_destroy();
    header('location:login.php');
    exit();
}

$fetch = [];

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fetch = $result->fetch_assoc();
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stud_name = $fetch['name']; // Use the student name from the fetched details
    $thot = $_POST['thot'];
    $anonymous = isset($_POST['anonymous']) ? "Yes" : "No"; // Use "Yes" or "No" based on checkbox state

    $stmt = $conn->prepare("INSERT INTO thots (stud_name, thot, anony) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $stud_name, $thot, $anonymous);

    if ($stmt->execute()) {
        $_SESSION['success_message'];
        header('location: userthots.php?user_id=' . $user_id); // Redirect to avoid form resubmission
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }    

    $stmt->close();
}

$sql = "SELECT id, stud_name, thot FROM thots";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $thoughts = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $thoughts = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Freedom wall</title>
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
    </style>
</head>
<body>
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message"><?php echo $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); // Clear the success message ?>
<?php endif; ?>


<div class="sidebar">
    <!-- Other sidebar links with icons and names -->
    <a href="userhome.php" class="btn"><i class="fas fa-home"></i>Home</a>
    <a href="user_updp.php" class="btn"><i class="fas fa-user-edit"></i>Update Profile</a>
    <a href="searchsched.php" class="btn"><i class="fas fa-search"></i>Search Schedule</a>
    <a href="userthots.php?user_id=<?php echo $user_id; ?>" class="btn"><i class="fas fa-pen-square"></i>Post on Wall</a>
    <a href="wallthots.php" class="btn"><i class="fas fa-comment"></i>Freedom Wall</a>
    <a href="userhome.php?logout=<?php echo $user_id; ?>" class="delete-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<div class="content">
    <div class="search-box">
    </div>
    <h1>FREEDOM WALL</h1>
    <div class="message-box">
    <h2><?php echo $fetch['name']; ?></h2>
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
                <li>
                    <?php echo $thought['stud_name'] . ': ' . $thought['thot']; ?>
                    <a href="#" class="delete-icon" data-thought-id="<?php echo $thought['id']; ?>" title="Delete"><i class="fas fa-trash-alt"></i></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = document.querySelector('.success-message');
        if (successMessage) {
            successMessage.style.display = 'block';
            alert("Pending thought waiting for admin approval."); // Display an alert
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 2000);
        }

        var deleteIcons = document.querySelectorAll('.delete-icon');
        deleteIcons.forEach(function (icon) {
            icon.addEventListener('click', function (e) {
                e.preventDefault();
                var thoughtId = this.getAttribute('data-thought-id');
                deleteThought(thoughtId);
            });
        });

        // Function to handle the success message after posting
        var postButton = document.getElementById('post-button');
        postButton.addEventListener('click', function () {
            alert('Pending thought waiting for admin approval.');
        });

        function deleteThought(thoughtId) {
            if (confirm("Are you sure you want to delete this thought?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var thoughtElement = document.querySelector('[data-thought-id="' + thoughtId + '"]');
                        if (thoughtElement) {
                            thoughtElement.parentNode.removeChild(thoughtElement);
                            alert(xhr.responseText); // Display the response from delete_thought.php
                            location.reload(); // Refresh the page
                        }
                    }
                };
                xhr.open("POST", "delete_thought.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("id=" + thoughtId);
            }
        }
    });
</script>
</html>