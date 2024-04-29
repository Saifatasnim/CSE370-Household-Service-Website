<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "household_service_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $admin_id = $_SESSION['id'];
        $admin_name = $_POST["admin_name"];

        $sql = "UPDATE Admin SET Name='$admin_name' WHERE Admin_ID='$admin_id'";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='success-message'>Profile updated successfully.</p>";
            echo "<p><a href='http://localhost/household_service_website/admin_home.php'>Back to Profile</a></p>";
        } else {
            echo "<p class='error-message'>Error updating profile: " . $conn->error . "</p>";
        }
    }

    $conn->close();
?>