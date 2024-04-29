<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Cancel Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .menu {
            background-color: #333;
            overflow: hidden;
        }
        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .menu a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: auto;
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .cancel-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="menu">
    <a href="http://localhost/household_service_website/admin_home.php">Profile</a>
    <a href="http://localhost/household_service_website/admin_cancel_request.php">Request</a>
    <a href="http://localhost/household_service_website/admin_complain.php">Complain</a>
    <a href="http://localhost/household_service_website/admin_status_update.php">Status Update</a>
    <a href="http://localhost/household_service_website/logout.php">Logout</a>
</div>

<div class="container">
    <h1>Admin Cancel Request</h1>
    <table>
        <thead>
        <tr>
            <th>Client Name</th>
            <th>Worker Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
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

        $admin_id = $_SESSION['id'];

        $sql = "SELECT * FROM Cancel_request WHERE Adminid='$admin_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $client_id = $row['Clientid'];
                $worker_id = $row['Requestid'];
                $sql_client = "SELECT * FROM Client WHERE Client_ID='$client_id'";
                $result_client = $conn->query($sql_client);
                $client_data = $result_client->fetch_assoc();
                $sql_worker = "SELECT * FROM Worker WHERE Worker_ID='$worker_id'";
                $result_worker = $conn->query($sql_worker);
                $worker_data = $result_worker->fetch_assoc();
                ?>
                <tr>
                    <td><?php echo $client_data['Name']; ?></td>
                    <td><?php echo $worker_data['Name']; ?></td>
                    <td><button class="cancel-btn" onclick="cancelRequest(<?php echo $client_id; ?>, <?php echo $worker_id; ?>)">Cancel</button></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='3'>No cancel requests found.</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<script>
    function cancelRequest(clientId, workerId) {
        var confirmCancel = confirm("Are you sure you want to cancel this request?");
        if (confirmCancel) {
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

                if(isset($_SESSION['id']) && isset($_POST['action']) && isset($_POST['client_id']) && isset($_POST['worker_id'])) {
                    $client_id = $_POST['client_id'];
                    $worker_id = $_POST['worker_id'];

                    if($_POST['action'] === 'cancel') {
                        $sql_update_hire = "UPDATE Hire SET Status = 'Rejected' WHERE Clientid = $client_id AND Workerid = $worker_id";

                        if ($conn->query($sql_update_hire) === TRUE) {
                            $sql_update_worker_status = "UPDATE Worker SET Status = 'Active' WHERE Worker_ID = $worker_id";

                            if ($conn->query($sql_update_worker_status) === TRUE) {
                                $sql_delete_payment = "DELETE FROM Payment WHERE Payment_Clientid = $client_id AND Payment_Workerid = $worker_id";

                                if ($conn->query($sql_delete_payment) === TRUE) {
                                    $sql_get_cost = "SELECT Cost FROM Hire WHERE Clientid = $client_id AND Workerid = $worker_id";
                                    $result_cost = $conn->query($sql_get_cost);

                                    if ($result_cost->num_rows > 0) {
                                        $row = $result_cost->fetch_assoc();
                                        $cost = $row['Cost'];
                                        $sql_update_client_due = "UPDATE Client SET Total_due = Total_due - $cost WHERE Client_ID = $client_id";

                                        if ($conn->query($sql_update_client_due) === TRUE) {
                                            echo "Request canceled successfully. Payment deleted and total due updated.";
                                        } else {
                                            echo "Error updating total due in Client table: " . $conn->error;
                                        }
                                    } else {
                                        echo "Error retrieving cost from Hire table: " . $conn->error;
                                    }
                                } else {
                                    echo "Error deleting payment information: " . $conn->error;
                                }
                            } else {
                                echo "Error updating worker status: " . $conn->error;
                            }
                        } else {
                            echo "Error updating hire status: " . $conn->error;
                        }
                    } else {
                        echo "Invalid action.";
                    }
                } else {
                    echo "Missing parameters.";
                }

                $conn->close();
                ?>


        }
    }
</script>

</body>
</html>
