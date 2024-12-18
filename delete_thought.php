<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $thoughtId = $_POST['id'];
        $sql = "DELETE FROM thots WHERE id = '$thoughtId'";
        if (mysqli_query($conn, $sql)) {
            echo "Thought deleted successfully";
        } else {
            echo "Error deleting thought: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid request";
    }
} else {
    echo "Invalid request method";
}
?>
