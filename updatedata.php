<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Edit and Update Data</title>
</head>
<body>
    <?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection, 'lovely');

    $id = $_POST['id'];

    $query = "SELECT * FROM schedule WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        while($row = mysqli_fetch_array($query_run))
        {
            ?>
            <div class="container">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-md-12">
                            
                            
                            <h2> Update Schedule</h2>
                            <hr>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <div class="form-group">
                                    <label for=""> Subject </label>
                                    <input type="text" name="subject" class="form-control" value="<?php echo $row['subject'] ?>" placeholder="Enter subject" required>
                                </div>
                                <div class="form-group">
                                    <label for=""> Instructor </label>
                                    <input type="text" name="instructor" class="form-control" value="<?php echo $row['instructor'] ?>" placeholder="Enter instructor" required>
                                </div>
                                <div class="form-group">
                                    <label for=""> day </label>
                                    <input type="text" name="day" class="form-control" value="<?php echo $row['day'] ?>" placeholder="Enter day" required>
                                </div>
                                <div class="form-group">
                                    <label for=""> time </label>
                                    <input type="text" name="time" class="form-control" value="<?php echo $row['time'] ?>" placeholder="Enter time" required>
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
                                    <label for=""> room </label>
                                    <input type="text" name="room" class="form-control" value="<?php echo $row['room'] ?>" placeholder="Enter room" required>
                                </div>

                                <button type="submit" name="update" class="btn btn-primary"> Update Data </button>

                                <a href="index.php" class="btn btn-danger"> CANCEL </a>
                            </form>

                        </div>
                    </div>
                    
                    <?php
                    if (isset($_POST['update'])) {
                        $subject = $_POST['subject'];
                        $instructor = $_POST['instructor'];
                        $day = $_POST['day'];
                        $time = $_POST['time'];
                        $type = $_POST['type'];
                        $room = $_POST['room'];
                    
                        $query = "UPDATE schedule SET subject='$subject', instructor='$instructor', day='$day', time='$time', type='$type', room='$room' WHERE id='$id'";
                        $query_run = mysqli_query($connection, $query);
                    
                        if ($query_run) {
                            echo '<script> alert("Data Updated"); </script>';
                            header("location:index.php");
                        } else {
                            echo '<script> alert("Data Not Updated"); </script>';
                        }
                    }
                    ?>

                </div>
            </div>
            <?php
        }
    }
    else
    {
        // echo '<script> alert("No Record Found"); </script>';
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>No Record Found</h4>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</body>
</html>