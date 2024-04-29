<!DOCTYPE html>
<html>
<head>
    <title>Client Home Page</title>
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
        .hired-worker-info {
            margin-top: 20px;
        }
        .hired-worker-info p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<div class="menu">
    <a href="http://localhost/household_service_website/client_home.php">Profile</a>
    <a href="http://localhost/household_service_website/client_review.php">Review</a>
    <a href="http://localhost/household_service_website/client_rating.php">Rating</a>
    <a href="http://localhost/household_service_website/client_complain.php">Complain</a>
    <a href="http://localhost/household_service_website/client_cancel_request.php">Cancel Request</a>
    <a href="http://localhost/household_service_website/client_hire.php">Hire</a>
    <a href="http://localhost/household_service_website/client_payment.php">Payment</a>
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
        $client_id = $_SESSION['id'];

        $sql = "SELECT Name, Total_due FROM Client WHERE Client_ID = $client_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $client_name = $row["Name"];
                $total_due = $row["Total_due"];

                echo "<h2>Client Profile</h2>";
                echo "<p><strong>ID:</strong> $client_id</p>";
                echo "<p><strong>Name:</strong> $client_name</p>";
                echo "<p><strong>Total Due:</strong> $total_due</p>";
            }
        } else {
            echo "0 results";
        }
        echo "<form action='http://localhost/household_service_website/client_update.php' method='post'>";
        echo "<input type='hidden' name='client_id' value='$client_id'>";
        echo "<button type='submit' class='edit-profile-btn'>Update Profile</button>";
        echo "</form>";

        // Get hired worker info
        $sql_hired_worker = "SELECT w.Name, w.Age, w.Gender, w.Type, w.Rating FROM Worker w 
                            INNER JOIN Hire h ON w.Worker_ID = h.Workerid 
                            WHERE h.Clientid = $client_id AND h.Status = 'Accepted'";
        $result_hired_worker = $conn->query($sql_hired_worker);

        if ($result_hired_worker->num_rows > 0) {
            echo "<div class='hired-worker-info'>";
            echo "<h2>Hired Worker Info</h2>";
            while($row = $result_hired_worker->fetch_assoc()) {
                $worker_name = $row["Name"];
                $worker_age = $row["Age"];
                $worker_gender = $row["Gender"];
                $worker_type = $row["Type"];
                $worker_rating = $row["Rating"];

                echo "<p><strong>Name:</strong> $worker_name</p>";
                echo "<p><strong>Age:</strong> $worker_age</p>";
                echo "<p><strong>Gender:</strong> $worker_gender</p>";
                echo "<p><strong>Type:</strong> $worker_type</p>";
                echo "<p><strong>Rating:</strong> $worker_rating</p>";
            }
            echo "</div>";
        } else {
            echo "<div class='hired-worker-info'>";
            echo "<h2>Hired Worker Info</h2>";
            echo "<p>No worker found</p>";
        }

    } else {
        echo "<p class='error-message'> Error </p>";
    }

    $conn->close();
    ?>

</div>

</body>
</html>
