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
        $client_id = $_SESSION['id'];
        $client_name = $_POST["client_name"];

        $sql = "UPDATE Client SET Name='$client_name' WHERE Client_ID='$client_id'";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='success-message'>Profile updated successfully.</p>";
            echo "<p><a href='http://localhost/household_service_website/client_home.php'>Back to Profile</a></p>";
        } else {
            echo "<p class='error-message'>Error updating profile: " . $conn->error . "</p>";
        }
    }

    $conn->close();
?>