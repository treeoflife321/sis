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

// Fetch and display data from the user_sched table
$dataQuery = "SELECT * FROM user_sched WHERE user_id = '$user_id'";
$dataResult = mysqli_query($conn, $dataQuery);

// Fetch user details
$userQuery = "SELECT * FROM users WHERE id = '$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$fetch = mysqli_fetch_assoc($userResult);

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

.container {
    display: flex;
    flex-direction: column;
    justify-content: left;
    margin-top: 20px; 
    margin-left: auto; 
    display: flex;
   flex-direction: column;
   align-items: flex-start;
}


.profile {
        width: auto;
        margin: 0 auto;
        padding: 20px;
        border-radius: 10px;
        box-sizing: border-box;
    }

      .profile-and-table {
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         margin-top: 20px; /* Adjust margin as needed */
      }

      

.profile h3 {
   margin-top: 10px; /* Add some space between the image and the text */
   font-size: 18px; /* Adjust font size as needed */
   color: white; /* Set text color */
   margin-left:15px;
}

.profile img {
   width: 150px;
   height: 150px;
   border-radius: 50%;
   margin-bottom: 10px;
   border: 2px solid #fff; /* Add a white border around the image */
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.data-storage {
   background-color: #f2f2f2;
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


.profile-and-schedule {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-top: 20px; /* Adjust margin as needed */
   }

   .profile-and-schedule .profile {
      width: auto;
      margin: 0 auto;
      padding: 20px;
      border-radius: 10px;
      box-sizing: border-box;
   }

   .profile-and-schedule .data-storage {
      background-color: #f2f2f2;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow-x: auto;
      margin-top: 20px; /* Adjust margin as needed */
   }
   h2 {
    font-size: 30px;
    color: white; /* Set the text color */
    margin-top: 20px; /* Add top margin */
    margin-bottom: 10px; /* Add bottom margin */
    margin-left:-550px;
}
.print-button {
        display: inline-block;
        padding: 10px 15px;
        margin: 10px 0;
        text-decoration: none;
        background-color: #4caf50;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-left: 10px
    }

    .print-button:hover {
        background-color: #4CAF50;
    }
   

h2 {
   margin-left:20px;
}

</style>


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
        <i class="fas fa-clipboard"></i>
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
   


<body>
<div class="col-md-12">
<div class="profile-and-schedule">
   <div class="container">
      <div class="profile">
            <?php
               if ($fetch['image'] == '') {
                  echo '<img src="images/default-avatar.png">';
               } else {
                  echo '<img src="uploaded_img/'.$fetch['image'].'">';
               }
            ?>
            <h3><?php echo $fetch['name']; ?></h3>
            <h3><?php echo $fetch['courseandyear']; ?></h3>
         </div>

         <h2><i class="fas fa-calendar-alt"></i> My Schedule</h2>
      <button class="print-button" onclick="printData()">Print Data</button>
      <a href="index.php" class="btn"><i class="fas fa-plus"></i>Add Schedule</a>
<hr style="border-top: 2px solid #ccc; width: 100%; margin-top: 20px;">

      

      <div class="data-storage"> 
      <table>
         <thead>
            <tr>
               <?php
               $columnsQuery = mysqli_query($conn, "SHOW COLUMNS FROM user_sched");
               while ($column = mysqli_fetch_assoc($columnsQuery)) {
                  if ($column['Field'] != 'num' && $column['Field'] != 'user_id' && $column['Field'] != 'id') {
                     echo '<th>' . $column['Field'] . '</th>';
                  }
               }
               ?>
            </tr>
         </thead>
         <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($dataResult)) {
               echo '<tr>';
               foreach ($row as $key => $value) {
                  if ($key != 'num' && $key != 'user_id' && $key != 'id') {
                     echo '<td>' . $value . '</td>';
                  }
               }
               echo '<td><a href="deletesched.php?id=' . $row['id'] . '" class="delete-btn"><i class="fas fa-trash"></i></a></td>';

               echo '</tr>';
            }
            ?>
         </tbody>
      </table>
      </div>
   </div>
</div>


<script>

document.getElementById("hamburgerIcon").addEventListener("click", function() {
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

   function printData() {
      var printWindow = window.open('', '_blank');
      printWindow.document.write('<html><head><title>Print</title></head><body>');
      printWindow.document.write(document.querySelector('.data-storage').innerHTML);
      printWindow.document.write('</body></html>');
      printWindow.document.close();

      // Attach an event listener to check if the user cancels the print operation
      printWindow.onafterprint = function() {
         // Redirect to home.php after a short delay
         setTimeout(function() {
            printWindow.close();
            window.location.href = 'userhome.php';
         }, 1000); // Adjust the delay time as needed
      };

      // Trigger the print dialog
      printWindow.print();
   }

   const hamburgerIcon = document.getElementById("hamburgerIcon");
const sidebar = document.querySelector(".sidebar");
const content = document.querySelector(".container");

hamburgerIcon.addEventListener("click", function() {
    sidebar.classList.toggle("active");
    content.classList.toggle("active-sidebar");

    // Toggle the display of link names based on sidebar activity
    const linkNames = document.querySelectorAll('.link-name');
    linkNames.forEach(name => {
        name.classList.toggle('visible');
    });

    // Toggle the visibility of link names
    const areNamesVisible = sidebar.classList.contains('active');
    linkNames.forEach(name => {
        name.style.display = areNamesVisible ? 'inline' : 'none';
    });
});

// Hide sidebar when the user clicks outside the sidebar
document.addEventListener("click", function(e) {
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