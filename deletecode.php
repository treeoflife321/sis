<?php

$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection, 'lovely');

if(isset($_POST['delete']))
{
    $id = $_POST['id'];

    $query = "DELETE FROM schedule WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        echo '<script> alert("Data Deleted"); </script>';
        header("location:index.php");
    }
    else
    {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}

?>