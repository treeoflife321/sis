<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Manage Schedule</title>
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

        .container {
    display: flex;
    flex-direction: column;
    justify-content: left;
    margin-top: 20px; 
    margin-left: 150px; 
    display: flex;
   flex-direction: column;
   align-items: flex-start;
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
            border: 2px solid #ccc;
            text-align: left;
        }

        table th,
        table td {
            transition: background-color 0.3s;
        }

        table th:hover,
        table td:hover {
            background-color: blue;
        }

        .jumbotron {
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: auto; /* Center the jumbotron horizontally */
    margin-top: 20px;
    width: 80%; /* You can adjust the width as needed */
}
.sidebar a:first-child {
    margin-top: 20px; /* Provide space between hamburger and Home button */
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
            <div class="row">
            <div class="col-md-7">
                    <h2>USTP Schedules</h2>
                    
                
                <div class="col-md-12">
                <a href="insertdata.php" class="btn btn-success" style="margin-left: 80%;"> Add Schedule </a>
                    <hr>
                </div>
            </div>

            <div class="row">
                
            
                    <!-- Search form -->
                    <form action="" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search Data">
                            <button type="submit" class="btn btn-primary">Search</button> 
                        </div>
                    </form>
            </div>

            <?php
            $connection = mysqli_connect("localhost","root","");
            $db = mysqli_select_db($connection, 'lovely');

            // Check if the search form is submitted
            if(isset($_GET['search']) && !empty($_GET['search'])) {
                $searchKeyword = $_GET['search'];
                $query = "SELECT * FROM schedule WHERE 
                           subject LIKE '%$searchKeyword%' OR 
                           instructor LIKE '%$searchKeyword%' OR 
                           day LIKE '%$searchKeyword%' OR 
                           time LIKE '%$searchKeyword%' OR 
                           type LIKE '%$searchKeyword%' OR 
                           room LIKE '%$searchKeyword%'";
            } else {
                // If search box is empty, show all data
                $query = "SELECT * FROM schedule";
            }

            $query_run = mysqli_query($connection, $query);
            ?>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered" style="background-color: #fcc000;">
                        <thead class="table-dark">
                            <tr>
                                <th> ID </th>
                                <th> Subject </th>
                                <th> Instructor </th>
                                <th> Day </th>
                                <th> Time </th>
                                <th> Type </th>
                                <th> Room </th>
                                <th> Edit </th>
                                <th> Delete </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($query_run) {
                            while($row = mysqli_fetch_array($query_run)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['instructor']; ?></td>
                                    <td><?php echo $row['day']; ?></td>
                                    <td><?php echo $row['time']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['room']; ?></td>
                                    <td>
    <form action="updatedata.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <button type="submit" name="edit" class="btn btn-success"><i class="fas fa-edit"></i></button>
    </form>
</td>

<td>
    <form action="deletecode.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <button type="submit" name="delete" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
    </form>
</td>

                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8">No Record Found</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
