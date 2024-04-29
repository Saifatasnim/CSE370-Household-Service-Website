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

$client_id = $_POST['client_id'];
$worker_id = $_POST['worker_id'];
$cost = $_POST['cost'];

if($_POST['action'] === 'accept') {
    $sql_update_hire = "UPDATE Hire SET Status = 'Accepted' WHERE Clientid = $client_id AND Workerid = $worker_id";
    if ($conn->query($sql_update_hire) === TRUE) {
        $sql_insert_payment = "INSERT INTO Payment (Payment_Clientid, Payment_Workerid, Cost, Status) VALUES ($client_id, $worker_id, $cost, 'unpaid')";   // Insert data into payment table
        if ($conn->query($sql_insert_payment) === TRUE) {
            $sql_update_worker = "UPDATE Worker SET Status = 'Inactive' WHERE Worker_ID = $worker_id";    // Update worker status to 'Inactive'
            if ($conn->query($sql_update_worker) === TRUE) {
                $sql_total_due = "SELECT Total_due FROM Client WHERE Client_ID = $client_id";    // Retrieve current total due of the client
                $result_total_due = $conn->query($sql_total_due);
                if ($result_total_due->num_rows > 0) {
                    $row_total_due = $result_total_due->fetch_assoc();
                    $current_total_due = $row_total_due['Total_due'];
                    $new_total_due = $current_total_due + $cost;       // Calculate new total due after accepting hire request
                    $sql_update_total_due = "UPDATE Client SET Total_due = $new_total_due WHERE Client_ID = $client_id";   // Update total due in Client table
                    if ($conn->query($sql_update_total_due) === TRUE) {
                        echo "Hire request accepted successfully. Total due updated. <br>";
                        echo "<button onclick='goBack()'>Go Back</button>";
                    } else {
                        echo "Error updating total due: " . $conn->error;
                    }
                } else {
                    echo "Error retrieving total due of client.";
                }
            } else {
                echo "Error updating worker status: " . $conn->error;
            }
        } else {
            echo "Error inserting data into payment table: " . $conn->error;
        }
    } else {
        echo "Error updating hire status: " . $conn->error;
    }
} elseif ($_POST['action'] === 'reject') {
    $sql_update_hire = "UPDATE Hire SET Status = 'Rejected' WHERE Clientid = $client_id AND Workerid = $worker_id";
    if ($conn->query($sql_update_hire) === TRUE) {
        echo "Hire request rejected successfully. <br>";
        echo "<button onclick='goBack()'>Go Back</button>";
    } else {
        echo "Error updating hire status: " . $conn->error;
    }
} else {
    echo "Invalid action.";
}

$conn->close();

echo "<script>";
echo "function goBack() {";
echo "window.history.back();";
echo "}";
echo "</script>";
?>
