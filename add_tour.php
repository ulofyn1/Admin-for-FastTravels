<?php
session_start();

if (!isset($_SESSION['admin_authenticated'])) {
    header("Location: admin_login.php");
    exit;
}
include('includes/db_config.php'); // Used an external file for database credentials

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $date = $_POST['date'];
    $capacity = $_POST['capacity'];

    
    $query = "INSERT INTO tours (location, tour_date, tour_capacity) VALUES ('$location', '$date', $capacity)";

    if ($conn->query($query) === true) {
        $_SESSION['message'] = "Tour added successfully.";
        // Redirect back to the admin panel
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>