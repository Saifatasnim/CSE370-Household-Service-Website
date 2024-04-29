<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "household_service_database";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if workerId is set
    if(isset($_POST['workerId'])) {
        $workerId = $_POST['workerId'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch current status of worker
        $sql = "SELECT Status FROM Worker WHERE Worker_ID = $workerId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentStatus = $row['Status'];
            // Toggle status
            $newStatus = ($currentStatus === 'Active') ? 'Inactive' : 'Active';
            // Update status in Worker table
            $updateSql = "UPDATE Worker SET Status = '$newStatus' WHERE Worker_ID = $workerId";
            if ($conn->query($updateSql) === TRUE) {
                echo "Status updated successfully!";
            } else {
                echo "Error updating status: " . $conn->error;
            }
        } else {
            echo "Worker not found!";
        }

        $conn->close();
    } else {
        echo "Worker ID not provided!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Worker Status</title>
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
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
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
    <h1>Admin Worker Status</h1>
    <table>
        <thead>
        <tr>
            <th>Worker Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch all workers
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT Worker_ID, Name, Status FROM Worker";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="workerId" value="<?php echo $row['Worker_ID']; ?>">
                            <label class="switch">
                                <input type="checkbox" onchange="this.form.submit()" <?php if($row['Status'] === 'Active') echo 'checked'; ?>>
                                <span class="slider round"></span>
                            </label>
                        </form>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='3'>No workers found.</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
