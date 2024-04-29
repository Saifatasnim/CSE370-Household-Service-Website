<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Hire Requests</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
        .accept-btn, .reject-btn {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .accept-btn {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .reject-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            margin-left: 5px;
        }
        .accept-btn:hover, .reject-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="menu">
    <a href="http://localhost/household_service_website/Worker_home.php">Profile</a>
    <a href="http://localhost/household_service_website/worker_hire_request.php">Hire Request</a>
    <a href="http://localhost/household_service_website/worker_payment.php">Payment</a>
    <a href="http://localhost/household_service_website/logout.php">Logout</a>
</div>

<div class="container">
    <h1>Worker Hire Requests</h1>
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

        if(isset($_SESSION['id'])) {
            $worker_id = $_SESSION['id'];

            $sql = "SELECT * FROM Hire WHERE Workerid = $worker_id AND Status = 'Pending'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr><th>Client Name</th><th>Duration</th><th>Cost</th><th>Action</th></tr></thead>";
                echo "<tbody>";
                while($row = $result->fetch_assoc()) {
                    $client_id = $row["Clientid"];
                    $duration = $row["Duration"];
                    $cost = $row["Cost"];

                    // Retrieve client name
                    $sql_client = "SELECT Name FROM Client WHERE Client_ID = $client_id";
                    $result_client = $conn->query($sql_client);
                    if ($result_client->num_rows > 0) {
                        $row_client = $result_client->fetch_assoc();
                        $client_name = $row_client["Name"];
                    } else {
                        $client_name = "N/A";
                    }

                    echo "<tr>";
                    echo "<td>$client_name</td>";
                    echo "<td>$duration months</td>";
                    echo "<td>$cost</td>";
                    echo "<td>";
                    echo "<form action='worker_process_hire_request.php' method='post'>";
                    echo "<input type='hidden' name='client_id' value='$client_id'>";
                    echo "<input type='hidden' name='worker_id' value='$worker_id'>";
                    echo "<input type='hidden' name='cost' value='$cost'>";
                    echo "<button type='submit' class='accept-btn' name='action' value='accept'>Accept</button>";
                    echo "<button type='submit' class='reject-btn' name='action' value='reject'>Reject</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No hire requests found.";
            }
        } else {
            echo "Session not found.";
        }

        $conn->close();
        ?>
</div>

</body>
</html>
