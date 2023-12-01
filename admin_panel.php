<?php
session_start();
 

if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>
<!--the above is checking if the user is authenticated as an admin by examining the 'admin_authenticated' session variable. 
 the user is not authenticated, it redirects them to the 'admin_login.php' page.-->

<!DOCTYPE html>
<html>
<head>
    <title>FastTravel Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="admin_styles.css">
    <style>
        table {
            border-collapse: separate;
            width: 50%;
        }
        form {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr {
            margin-bottom: 10px;
        }
        .modify-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .modify-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>


    <h1>FastTravel Admin Panel</h1>

    <!-- Add New Tour Form -->
    <h2>Add New Tour</h2>
    <form action="add_tour.php" method="post">
        <label for="location">Tour Location:</label>
        <input type="text" name="location" required><br>

        <label for = "date">Tour Date:</label>
        <input type="date" name="date" required><br>

        <label for="capacity">Tour Capacity:</label>
        <input type="number" name="capacity" required><br>

        <input type="submit" value="Add Tour">
    </form>
	<?php include('includes/db_config.php'); ?>
	
    <!-- Modify Existing Tours -->
    <h2>Modify Existing Tours</h2>
    <table> 
        <tr>
            <th>Tour ID</th>
            <th>Location</th>
            <th>Date</th>
            <th>Capacity</th>
            <th>Action</th>
        </tr>

        <?php
        // Include the database configuration
        include('includes/db_config.php');

        // Create an SQL query to fetch existing tours
        $sql = "SELECT tour_id, location, tour_date, tour_capacity FROM tours";

        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['tour_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tour_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tour_capacity']) . "</td>";
                    echo "<td><form action='modify_tour.php' method='post'>";
                    echo "<input type='hidden' name='tour_id' value='" . htmlspecialchars($row['tour_id']) . "'>";
                    echo "<input type='submit' class='modify-button' value='Modify'>";
                    echo "</form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No tours found</td></tr>";
            }
        } else {
            // Log the error instead of displaying it
            error_log("Database error: " . $conn->error);
        }

        // Close the database connection
        $conn->close();
        ?>
    </table>
</body>
</html>
