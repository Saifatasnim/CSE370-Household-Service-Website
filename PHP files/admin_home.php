<!DOCTYPE html>
<html>
<head>
    <title>Admin Home Page</title>
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
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .edit-profile-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .edit-profile-btn:hover {
            background-color: #0056b3;
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
            $admin_id = $_SESSION['id'];

            $sql = "SELECT Name FROM Admin WHERE Admin_ID = $admin_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $admin_name = $row["Name"];

                    echo "<h2>Admin Profile</h2>";
                    echo "<p><strong>ID:</strong> $admin_id</p>";
                    echo "<p><strong>Name:</strong> $admin_name</p>";
                }
            } else {
                echo "0 results";
            }
            echo "<form action='http://localhost/household_service_website/admin_update.php' method='post'>";
            echo "<input type='hidden' name='admin_id' value='$admin_id'>";
            echo "<button type='submit' class='edit-profile-btn'>Update Profile</button>";
            echo "</form>";

        } else {
            echo "<p class='error-message'> Error </p>";
        }
        
        $conn->close();
        ?>

</div>

</body>
</html>
