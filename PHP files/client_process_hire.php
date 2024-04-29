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
        if(isset($_POST['worker_id']) && isset($_POST['cost']) && isset($_POST['duration'])) {
            $client_id = $_SESSION['id'];
            $worker_id = $_POST['worker_id'];
            $cost = $_POST['cost'];
            $duration = $_POST['duration'];

            $sql_check_hire = "SELECT * FROM Hire WHERE Clientid = '$client_id' AND Workerid = '$worker_id'";
            $result = $conn->query($sql_check_hire);

            if ($result && $result->num_rows > 0) {
                $sql_update_hire = "UPDATE Hire SET Duration = '$duration', Cost = '$cost' 
                                    WHERE Clientid = '$client_id' AND Workerid = '$worker_id'";

                if ($conn->query($sql_update_hire) === TRUE) {
                    echo '<p>Request updated successfully!</p>';
                } else {
                    echo '<p>Error updating request: ' . $conn->error . '</p>';
                }
            } else {
                $sql_insert_hire = "INSERT INTO Hire (Clientid, Workerid, Duration, Cost) 
                                    VALUES ('$client_id', '$worker_id', '$duration', '$cost')";

                if ($conn->query($sql_insert_hire) === TRUE) {
                    echo '<p>Request sent successfully!</p>';
                    echo "<button onclick='goBack()'>Go Back</button>";
                } else {
                    echo '<p>Error sending request: ' . $conn->error . '</p>';
                }
            }
        } else {
            echo '<p>All fields are required!</p>';
        }
    }
    $conn->close();
?>
