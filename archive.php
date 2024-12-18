<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'lovely');

// Check if a semester button is clicked
if (isset($_GET['semester'])) {
    $selected_semester = $_GET['semester'];

    // Determine date ranges for first and second semesters
    if ($selected_semester === 'first') {
        $date_condition = "MONTH(timestamp) >= 8 OR MONTH(timestamp) <= 1";
    } else {
        $date_condition = "MONTH(timestamp) >= 2 AND MONTH(timestamp) <= 7";
    }

    // Fetch data from the archive table based on the selected semester
    $query_archive_data = "SELECT * FROM archive WHERE $date_condition ORDER BY timestamp DESC";
} else {
    // Fetch all data from the archive table ordered by timestamp
    $query_archive_data = "SELECT * FROM archive ORDER BY timestamp DESC";
}

$query_archive_result = mysqli_query($connection, $query_archive_data);

// Check if there are results
if (mysqli_num_rows($query_archive_result) > 0) {
    $archive_data = mysqli_fetch_all($query_archive_result, MYSQLI_ASSOC);
} else {
    $message = "No data found in the archive table";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Archive Dashboard</title>
</head>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
    @media print {
    body * {
        visibility: hidden;
    }

    .archive-data-table-print,
    .archive-data-table-print * {
        visibility: visible;
    }

    .archive-data-table-print {
        position: absolute;
        left: 0;
        top: 0;
    }
}
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

    .sidebar:not(.active) .btn {
    display: block;
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

<body>
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
    ?>

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

    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-12">
                    <h2> Archive Dashboard </h2>
                    <hr>
                    <?php if (isset($message)) : ?>
                        <p><?= $message ?></p>
                    <?php endif; ?>

                    <form action="archive.php" method="GET">
                        <button type="submit" name="semester" value="first" class="btn btn-primary print-hidden">First Semester</button>
                        <button type="submit" name="semester" value="second" class="btn btn-primary print-hidden">Second Semester</button>
                    </form>

                    <?php if (isset($archive_data)) : ?>
                        <button onclick="printArchive()" class="btn btn-success print-hidden">Print</button>
                    <?php endif; ?>
                    <div class="archive-data-table">
        <?php if (isset($archive_data)) : ?>
            <table class="table archive-data-table-print">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Instructor</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Room</th>
                        <!-- The "Semester" column will be hidden -->
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($archive_data as $row) : ?>
                        <tr>
                            <td><?= $row['subject'] ?></td>
                            <td><?= $row['instructor'] ?></td>
                            <td><?= $row['day'] ?></td>
                            <td><?= $row['time'] ?></td>
                            <td><?= $row['type'] ?></td>
                            <td><?= $row['room'] ?></td>
                            <!-- The "Semester" column will be hidden -->
                            <td><?= $row['timestamp'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function printArchive() {
            window.print();
        }
    </script>
</body>

</html>
