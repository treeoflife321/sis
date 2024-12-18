<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>PHP CRUD - Edit and Update Data</title>
</head>
<body>

<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'lovely');

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search_subject = $_POST['search_subject'];
    $query = "SELECT * FROM schedule WHERE subject LIKE '%$search_subject%'";
} else {
    $query = "SELECT * FROM schedule";
}

$query_run = mysqli_query($connection, $query);
?>

<div class="row">
    <div class="col-md-6">
        <form action="search.php" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search by subject" name="search_subject">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

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
                </tr>
            </thead>
            <tbody>

            <?php
            if ($query_run) {
                while ($row = mysqli_fetch_array($query_run)) {
                    ?>
                    <tr>
                        <th> <?php echo $row['id']; ?> </th>
                        <th> <?php echo $row['subject']; ?> </th>
                        <th> <?php echo $row['instructor']; ?> </th>
                        <th> <?php echo $row['day']; ?> </th>
                        <th> <?php echo $row['time']; ?> </th>
                        <th> <?php echo $row['type']; ?> </th>
                        <th> <?php echo $row['room']; ?> </th>
                        <th>
                            <form action="updatedata.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <input type="submit" name="edit" class="btn btn-success" value="EDIT">
                            </form>
                        </th>
                        <th>
                            <form action="deletecode.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <input type="submit" name="delete" class="btn btn-danger" value="DELETE">
                            </form>
                        </th>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <th colspan="7"> No Record Found </th>
                </th>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
