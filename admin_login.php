<?php
// Start the session
session_start();

// Define admin credentials
$admin_username = "tete"; // the admin username
$admin_password = "princetete"; // the admin password

$login_error = ''; // errro message that will show if there is an error in the credentials

// this action checks if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // this action checks if the entered credentials match the admin's credentials
    if ($entered_username === $admin_username && $entered_password === $admin_password) {
        // Authentication successful
        $_SESSION['admin_authenticated'] = true;
        // if true then the page is redirected to the admin panel
        header("Location: admin_panel.php");
        exit; // Always call exit after a header redirect
    } else {
        // Authentication failed
        $login_error = "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>

    <?php
    if ($login_error) {
        echo "<p>" . htmlspecialchars($login_error) . "</p>"; // this line ensures that the error message is safely displayed as text   
        
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
