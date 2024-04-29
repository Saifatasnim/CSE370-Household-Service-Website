<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Payment Page</title>
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
        .total-balance {
            margin-bottom: 20px;
            font-weight: bold;
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
        .pay-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .pay-btn:hover {
            background-color: #218838;
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
    <h1>Worker Payment Page</h1>
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

            // Retrieve total balance from payment table
            $sql_balance = "SELECT SUM(Cost) AS total_balance FROM Payment WHERE Payment_Workerid = $worker_id AND Status = 'paid'";
            $result_balance = $conn->query($sql_balance);
            if ($result_balance->num_rows > 0) {
                $row = $result_balance->fetch_assoc();
                $total_balance = $row["total_balance"];
                echo "<div class='total-balance'>Total Balance: $total_balance</div>";
            } else {
                echo "Total balance not found.";
            }

            // Retrieve all payments for the worker
            $sql_payments = "SELECT * FROM Payment WHERE Payment_Workerid = $worker_id";
            $result_payments = $conn->query($sql_payments);

            if ($result_payments->num_rows > 0) {
                echo "<table>";
                echo "<thead><tr><th>Client</th><th>Cost</th><th>Status</th></tr></thead>";
                echo "<tbody>";
                while($row = $result_payments->fetch_assoc()) {
                    echo "<td>" . $row["Payment_Clientid"] . "</td>";
                    echo "<td>" . $row["Cost"] . "</td>";
                    echo "<td>" . $row["Status"] . "</td>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No payments found.";
            }
        } else {
            echo "Session not found.";
        }

        $conn->close();
        ?>
</div>

</body>
</html>
