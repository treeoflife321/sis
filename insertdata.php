<?php

$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'lovely');

// Fetch unique values for subject
$query_subjects = "SELECT DISTINCT subject FROM schedule";
$result_subjects = mysqli_query($connection, $query_subjects);

// Fetch unique values for instructor
$query_instructors = "SELECT DISTINCT instructor FROM schedule";
$result_instructors = mysqli_query($connection, $query_instructors);

// Fetch unique values for day
$query_days = "SELECT DISTINCT day FROM schedule";
$result_days = mysqli_query($connection, $query_days);

// Fetch unique values for room
$query_rooms = "SELECT DISTINCT room FROM schedule";
$result_rooms = mysqli_query($connection, $query_rooms);

if (isset($_POST['insert'])) {
    $subject = ($_POST['subject'] == 'Other') ? $_POST['other_subject'] : $_POST['subject'];
    $instructor = ($_POST['instructor'] == 'Other') ? $_POST['other_instructor'] : $_POST['instructor'];
    $day = ($_POST['day'] == 'Other') ? $_POST['other_day'] : $_POST['day'];
    $time = $_POST['time'];
    $type = $_POST['type'];
    $room = ($_POST['room'] == 'Other') ? $_POST['other_room'] : $_POST['room'];

    $query = "INSERT INTO schedule(`subject`,`instructor`,`day`,`time`,`type`,`room`) VALUES ('$subject','$instructor','$day','$time','$type','$room')";
    $query_run = mysqli_query($connection, $query);

    $query_archive = "INSERT INTO archive(`subject`,`instructor`,`day`,`time`,`type`,`room`) VALUES ('$subject','$instructor','$day','$time','$type','$room')";
    $query_archive_run = mysqli_query($connection, $query_archive);

    if ($query_run && $query_archive_run) {
        header('Location: index.php');
        $message = "Data Saved Successfully!";
        exit();
    } else {
        echo '<script> alert("Data Not Saved"); </script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Add Schedule</title>
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
   background-size: cover;
   background-position: center;
}

.wrapper {
    text-align: auto;
    width: 100vw; /* Full viewport width */
    height: 100vh; /* Full viewport height */
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
    border-radius: 3px;
    font-size: 16px;
    color: #191970;
    padding: 20px 45px 20px 20px;
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
</style>

<body>
<div class="wrapper">
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-12">
                    <h2> Add Schedule </h2>
                    <hr>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for=""> Subject </label>
                            <select name="subject" class="form-control" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_subjects)) {
                                    echo "<option value='{$row['subject']}'>{$row['subject']}</option>";
                                }
                                ?>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="other_subject" class="form-control" placeholder="Enter Subject Manually" style="display:none;">
                        </div>
                        <div class="form-group">
                            <label for=""> Instructor </label>
                            <select name="instructor" class="form-control" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_instructors)) {
                                    echo "<option value='{$row['instructor']}'>{$row['instructor']}</option>";
                                }
                                ?>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="other_instructor" class="form-control" placeholder="Enter Instructor Manually" style="display:none;">
                        </div>
                        <div class="form-group">
                            <label for=""> day </label>
                            <select name="day" class="form-control" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_days)) {
                                    echo "<option value='{$row['day']}'>{$row['day']}</option>";
                                }
                                ?>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="other_day" class="form-control" placeholder="Enter Day Manually" style="display:none;">
                        </div>
                        <div class="form-group">
                            <label for=""> time </label>
                            <input type="text" name="time" class="form-control" placeholder="Enter time" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Select Type:</label>
                            <select class="form-control" name="type" id="type">
                                <option value="Regular">Regular</option>
                                <option value="Exam">Exam</option>
                                <option value="Special">Special</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""> Room </label>
                            <select name="room" class="form-control" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_rooms)) {
                                    echo "<option value='{$row['room']}'>{$row['room']}</option>";
                                }
                                ?>
                                <option value="Other">Other</option>
                            </select>
                            <input type="text" name="other_room" class="form-control" placeholder="Enter Room Manually" style="display:none;">
                        </div>

                        <button type="submit" name="insert" class="btn btn-primary"> Save Data </button>

                        <a href="index.php" class="btn btn-danger"> BACK </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide manual input fields based on the selection
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('select[name="subject"]').addEventListener('change', function () {
                if (this.value === 'Other') {
                    document.querySelector('input[name="other_subject"]').style.display = 'block';
                } else {
                    document.querySelector('input[name="other_subject"]').style.display = 'none';
                }
            });

            document.querySelector('select[name="instructor"]').addEventListener('change', function () {
                if (this.value === 'Other') {
                    document.querySelector('input[name="other_instructor"]').style.display = 'block';
                } else {
                    document.querySelector('input[name="other_instructor"]').style.display = 'none';
                }
            });

            document.querySelector('select[name="day"]').addEventListener('change', function () {
                if (this.value === 'Other') {
                    document.querySelector('input[name="other_day"]').style.display = 'block';
                } else {
                    document.querySelector('input[name="other_day"]').style.display = 'none';
                }
            });

            document.querySelector('select[name="room"]').addEventListener('change', function () {
                if (this.value === 'Other') {
                    document.querySelector('input[name="other_room"]').style.display = 'block';
                } else {
                    document.querySelector('input[name="other_room"]').style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
