<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header('location: login.php');
   exit();
}

if (isset($_GET['id'])) {
   $schedule_id = $_GET['id'];
   $deleteQuery = "DELETE FROM user_sched WHERE id = '$schedule_id' AND user_id = '{$_SESSION['user_id']}'";
   mysqli_query($conn, $deleteQuery);
}

header('location: userhome.php');
exit();
?>
