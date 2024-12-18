<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

session_start();
$user_id = $_SESSION['user_id'];

// Initialize $selectedRow
$selectedRow = array();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get and sanitize the search terms
    $searchSubject = mysqli_real_escape_string($conn, $_POST['searchSubject']);
    $searchInstructor = mysqli_real_escape_string($conn, $_POST['searchInstructor']);
    $searchDay = mysqli_real_escape_string($conn, $_POST['searchDay']);
    $searchTime = mysqli_real_escape_string($conn, $_POST['searchTime']);
    $searchType = mysqli_real_escape_string($conn, $_POST['searchType']);
    $searchRoom = mysqli_real_escape_string($conn, $_POST['searchRoom']);

    // Build the WHERE clause based on provided search terms
    $whereClause = "WHERE 1"; // This is always true

    if (!empty($searchSubject)) {
        $whereClause .= " AND subject LIKE '%$searchSubject%'";
    }

    if (!empty($searchInstructor)) {
        $whereClause .= " AND instructor LIKE '%$searchInstructor%'";
    }

    if (!empty($searchDay)) {
        $whereClause .= " AND day LIKE '%$searchDay%'";
    }

    if (!empty($searchTime)) {
        $whereClause .= " AND time LIKE '%$searchTime%'";
    }

    if (!empty($searchType)) {
        $whereClause .= " AND type LIKE '%$searchType%'";
    }

    if (!empty($searchRoom)) {
        $whereClause .= " AND room LIKE '%$searchRoom%'";
    }

    $filterQuery = "SELECT * FROM schedule $whereClause";

    $filterResult = mysqli_query($conn, $filterQuery);

    // Check if there are results
    if (mysqli_num_rows($filterResult) > 0) {
        $filterData = mysqli_fetch_all($filterResult, MYSQLI_ASSOC);
    } else {
        $message = "No data found";
    }
} else {
    // If the form is not submitted, show all data
    $allDataQuery = "SELECT * FROM schedule";
    $allDataResult = mysqli_query($conn, $allDataQuery);

    if (mysqli_num_rows($allDataResult) > 0) {
        $filterData = mysqli_fetch_all($allDataResult, MYSQLI_ASSOC);
        // Set $selectedRow to the first row by default
        if (!empty($filterData)) {
            $selectedRow = $filterData[0];
        }
    } else {
        $message = "No data found";
    }
}

// Check if the move button is clicked
if (isset($_POST['saveToDashboard'])) {
    // Decode the JSON data
    $selectedRow = json_decode(urldecode($_POST['filterData']), true);

    // Check if the data already exists in user_sched for the current user
    $checkExistingQuery = "SELECT * FROM user_sched WHERE user_id = '$user_id' AND id = '{$selectedRow['id']}'";
    $existingResult = mysqli_query($conn, $checkExistingQuery);

    if (mysqli_num_rows($existingResult) > 0) {
        $errorMessage = "Data already exists in your schedule.";
    } else {
        // Insert the data into user_sched
        $insertUserSchedQuery = "INSERT INTO user_sched (user_id, id, subject, instructor, day, time, type, room) 
                                 VALUES ('$user_id', '{$selectedRow['id']}', '{$selectedRow['subject']}', '{$selectedRow['instructor']}', 
                                         '{$selectedRow['day']}', '{$selectedRow['time']}', '{$selectedRow['type']}', '{$selectedRow['room']}')";

        if (mysqli_query($conn, $insertUserSchedQuery)) {
            $successMessage = "Data successfully moved to T2.";
        } else {
            $errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Search Schedule</title>
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

      nav {
    position: fixed;
    width: 100%;
    top: 0;
    background-color: white;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    padding: 10px;
    border-radius: 5px;
}

        nav form {
            display: flex;
        }

        nav input[type="text"] {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        nav button {
            padding: 10px;
            margin: 5px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }


        table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    margin-top: 20px; /* Added margin-top to separate table from content */
    border-radius: 8px; /* Added border-radius for rounded corners */
    overflow: hidden; /* Added overflow for rounded corners */
}

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th,
        table td {
            transition: background-color 0.3s;
        }

        table th:hover,
        table td:hover {
            background-color: #45a049;
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

<body>

<div class="container">
<button onclick="printSearchResults()">Print Search Results</button>
<nav>
        <form action="searchschedadmin.php" method="POST">
            <input type="text" name="searchSubject" placeholder="Search by Subject">
            <input type="text" name="searchInstructor" placeholder="Search by Instructor">
            <input type="text" name="searchDay" placeholder="Search by Day">
            <input type="text" name="searchTime" placeholder="Search by Time">
            <input type="text" name="searchType" placeholder="Search by Type">
            <input type="text" name="searchRoom" placeholder="Search by oom">
            <button type="submit" name="submit">Search</button>
        </form>
</nav>


    <?php
    
    if (!isset($user_id)) {
        header('location:login.php');
        exit();
    }

    // Display the search results or a message
    if (isset($message)) {
        echo "<p>$message</p>";
    }

    // Display the success message if data is moved
    if (isset($successMessage)) {
        echo "<p>$successMessage</p>";
    }

    // Display the results in a form to move to t2.php
    if (isset($filterData)) {
        echo "<table border='1'>
                <tr>
                    <th>Subject</th>
                    <th>Instructor</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Room</th>
                    <th>Action</th>
                </tr>";
                foreach ($filterData as $row) {
                    echo "<tr>
                            <td>{$row['subject']}</td>
                            <td>{$row['instructor']}</td>
                            <td>{$row['day']}</td>
                            <td>{$row['time']}</td>
                            <td>{$row['type']}</td>
                            <td>{$row['room']}</td>
                            <td>
                                <form action='searchsched.php' method='POST'>
                                    <input type='hidden' name='filterData' value='" . urlencode(json_encode($row)) . "'>
                                    <button type='submit' name='saveToDashboard'>Save</button>
                                </form>
                            </td>
                        </tr>";
                }
                
        echo "</table>";
    }
    ?>

<script>
    // Display alert if there's an error message
    <?php if (isset($errorMessage)) : ?>
        alert("<?php echo $errorMessage; ?>");
    <?php endif; ?>

    function printSearchResults() {
        // Open a new window for printing
        var printWindow = window.open('', '_blank');
        
        // Write the search results table content to the new window
        printWindow.document.write('<html><head><title>Print Search Results</title></head><body>');
        printWindow.document.write('<h2>Search Results</h2>');
        printWindow.document.write(document.querySelector('table').outerHTML);
        printWindow.document.write('</body></html>');
        
        // Close the document in the new window
        printWindow.document.close();

        // Attach an event listener to check if the user cancels the print operation
        printWindow.onafterprint = function() {
            // Close the new window after printing or canceling
            printWindow.close();
        };

        // Trigger the print dialog
        printWindow.print();
    }


</script>

</body>

</html>
