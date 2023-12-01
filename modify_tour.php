<?php
// modify_tour.php

// Include the database configuration
include('includes/db_config.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tour_id = $_POST['tour_id'];

    // Fetch existing tour details based on tour ID
    $sql = "SELECT tour_id, location, tour_date, tour_capacity FROM tours WHERE tour_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tour_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the form for modifying tour details
        // You can use the existing form structure with pre-filled values
        // Update action attribute and include tour_id as a hidden input
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Modify Tour</title>
            <link rel="stylesheet" type="text/css" href="admin_styles.css">
            <!-- Additional styles if needed -->
        </head>
        <body>
            <h1>Modify Tour</h1>

            <form action="update_tour.php" method="post">
                <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($row['tour_id']); ?>">
                <!-- Add fields for modifying tour details, pre-filled with existing values -->
                <label for="location">Tour Location:</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required><br>

                <label for="date">Tour Date:</label>
                <input type="date" name="date" value="<?php echo htmlspecialchars($row['tour_date']); ?>" required><br>

                <label for="capacity">Tour Capacity:</label>
                <input type="number" name="capacity" value="<?php echo htmlspecialchars($row['tour_capacity']); ?>" required><br>

                <input type="submit" value="Update Tour">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Tour not found.";
    }

    // Close the database connection
    $stmt->close();
}
?>
