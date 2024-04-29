<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Complain Page</title>
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
    <h1>Admin Complain Page</h1>
    <table>
        <thead>
        <tr>
            <th>Client Name</th>
            <th>Complain</th>
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

        $sql = "SELECT * FROM Complain WHERE Adminid='$admin_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $client_id = $row['Clientid'];
                $complain = $row['Complain'];
                $sql_client = "SELECT * FROM Client WHERE Client_ID='$client_id'";
                $result_client = $conn->query($sql_client);
                $client_data = $result_client->fetch_assoc();
                ?>
                <tr>
                    <td><?php echo $client_data['Name']; ?></td>
                    <td><?php echo $complain; ?></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='2'>No complains found.</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
