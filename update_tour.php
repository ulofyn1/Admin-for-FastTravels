<?php
// update_tour.php

// Include the database configuration
include('includes/db_config.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tour_id = $_POST['tour_id'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $capacity = $_POST['capacity'];

    // Update tour details in the database
    $sql = "UPDATE tours SET location = ?, tour_date = ?, tour_capacity = ? WHERE tour_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $location, $date, $capacity, $tour_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect back to the admin panel
        header("Location: admin_panel.php");
        echo "Tour updated successfully.";
        exit();
    } else {
        echo "Failed to update tour.";
    }


    // Close the database connection
    $stmt->close();
}
?>
